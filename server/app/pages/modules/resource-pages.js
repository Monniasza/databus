var sparql = require('../../common/queries/sparql');
var request = require('request');

const DatabusCache = require('../../common/cache/databus-cache');
const ServerUtils = require('../../common/utils/server-utils.js');
const Constants = require('../../common/constants');
const UriUtils = require('../../common/utils/uri-utils');
const rp = require('request-promise');
const JsonldUtils = require('../../../../public/js/utils/jsonld-utils');
const DatabusUris = require('../../../../public/js/utils/databus-uris');
const { dataid } = require('../../common/queries/sparql');

module.exports = function (router, protector) {

  var cache = new DatabusCache(10);

  var licenseCache = new DatabusCache(3600, 100000);

  router.get('/:account', ServerUtils.HTML_ACCEPTED, protector.checkSso(), async function (req, res, next) {

    try {
      var auth = ServerUtils.getAuthInfoFromRequest(req);
      var accountData = await sparql.accounts.getAccount(req.params.account);

      if (accountData == null) {
        next('route');
        return;
      }

      res.render('account', {
        title: accountData.label,
        data: {
          auth: auth,
          username: req.params.account,
          profile: accountData,
        }
      });


    } catch (err) {
      console.log(err);
      next('route');
    }
  });

  router.get('/:account/collections', function (req, res, next) {
    return res.redirect('/' + req.params.account + '#collections');
  });

  router.get('/:account/services', function (req, res, next) {
    return res.redirect('/' + req.params.account + '#services');
  });

  router.get('/:account/apps', function (req, res, next) {
    return res.redirect('/' + req.params.account + '#apps');
  });

  router.get('/app/group/get-artifacts', async function (req, res, next) {
    try {
      var splits = UriUtils.splitResourceUri(req.query.uri);
      var accountName = splits[0];
      var groupName = splits[1];

      let cacheKey = `cache_key_artifacts__${accountName}_${groupName}`;

      let artifactData = await cache.get(cacheKey, async () => {
        return await sparql.dataid.getArtifactsByGroup(accountName, groupName);
      });

      res.status(200).send(artifactData);
    } catch (err) {
      res.status(400).send("Bad query");
    }
  });

  router.get('/:account/:group', ServerUtils.HTML_ACCEPTED, protector.checkSso(), async function (req, res, next) {

    try {
      // let groupData = await sparql.dataid.getGroup(req.params.account, req.params.group);

      let cacheKey = `cache_key_${req.params.account}_${req.params.group}`;
      let data = await cache.get(cacheKey, async () => {
        return {
          group: await sparql.dataid.getGroup(req.params.account, req.params.group)
        };
      });

      if (data.group == null) {
        next('route');
        return;
      }

      data.auth = ServerUtils.getAuthInfoFromRequest(req);
      var title = data.group.title != null ? data.group.title : UriUtils.uriToLabel(data.group.uri);

      res.render('group', {
        title: title,
        data: data,
      });

    } catch (err) {
      console.log(err);
      res.status(500).send(err);
    }
  });

  router.get('/:account/collections/:collection', ServerUtils.HTML_ACCEPTED, protector.checkSso(), async function (req, res, next) {
    try {
      let auth = ServerUtils.getAuthInfoFromRequest(req);
      let collectionData = await sparql.collections.getCollection(req.params.account, req.params.collection);

      if (collectionData == null) {
        next('route');
        return;
      }

      if (collectionData.issued === undefined &&
        (!auth.authenticated || req.params.publisher !== auth.info.username)) {
        res.status(404).send('This collection has been hidden by the author.');
        return;
      }

      res.render('collection', {
        title: collectionData.title,
        data: { collection: collectionData, auth: auth }
      });
    } catch (err) {
      res.status(500).send(err);
    }
  });

  router.get('/:account/:group/:artifact', protector.checkSso(), async function (req, res, next) {

    if (req.params.group == Constants.DATABUS_COLLECTIONS_GROUP_IDENTIFIER) {
      next('route');
      return;
    }

    try {

      let cacheKey = `ck_${req.params.account}_${req.params.group}_${req.params.artifact}`;
      let data = await cache.get(cacheKey, async () => {
        return {
          versions: await sparql.dataid.getVersionsByArtifact(req.params.account, req.params.group,
            req.params.artifact),
          artifact: await sparql.dataid.getArtifact(req.params.account, req.params.group, req.params.artifact)
        };
      });

      if (data.artifact == null) {
        next('route');
        return;
      }

      data.auth = ServerUtils.getAuthInfoFromRequest(req);

      res.render('artifact', {
        title: data.artifact.title,
        data: data
      });

    } catch (err) {
      console.log(err);
      res.status(500).send(err);
    }
  });

  router.get('/:account/:group/:artifact/:version', ServerUtils.HTML_ACCEPTED, protector.checkSso(), async function (req, res, next) {

    try {
      let cacheKey = `ck_${req.params.account}_${req.params.group}_${req.params.artifact}_${req.params.version}`;


      let data = await cache.get(cacheKey, async () => {
        return {
          version: await sparql.dataid.getVersion(req.params.account, req.params.group,
            req.params.artifact, req.params.version)
          //mods: await sparql.pages.getModsByVersion(req.params.account, req.params.group,
          //  req.params.artifact, req.params.version)
        };
      });

      // Only deliver the version graph
      var versionGraph = JsonldUtils.getTypedGraph(data.version, DatabusUris.DATAID_VERSION);
      data.version = [versionGraph];

      try {
        data.licenseData = await licenseCache.get('dalicc', async () => {
          return JSON.parse(await rp.get('https://api.dalicc.net/licenselibrary/list?limit=10000'));
        });
      } catch(err) {
        data.licenseData = null;
      }

      if (data.version == null) {
        next('route');
        return;
      }

      data.auth = ServerUtils.getAuthInfoFromRequest(req);
      res.render('version', { title: data.version.title, data: data });
    } catch (err) {
      console.log(err);
      res.status(404).send('Sorry cant find that!');
    }
  });
}
