var optionsRegex = /options\s=\s(.|\n|\r)*?;/gm;

var optionsString = window.onload.toString().match(optionsRegex)[0].replace('options = ', '').slice(0, -1);

function onLoad() {
  init('janni');
}

function init(username) {
  // Build a system
  var url = window.location.search.match(/url=([^&]+)/);
  if (url && url.length > 1) {
    url = decodeURIComponent(url[1]);
  } else {
    url = window.location.origin;
  }

  var options = JSON.parse(optionsString.replace(/%USERNAME%/g, username));

  url = options.swaggerUrl || url
  var urls = options.swaggerUrls
  var customOptions = options.customOptions
  var spec1 = options.swaggerDoc
  var swaggerOptions = {
    spec: spec1,
    url: url,
    urls: urls,
    dom_id: '#swagger-ui',
    deepLinking: true,
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    plugins: [
      SwaggerUIBundle.plugins.DownloadUrl
    ],
    layout: "StandaloneLayout"
  }
  for (var attrname in customOptions) {
    swaggerOptions[attrname] = customOptions[attrname];
  }
  var ui = SwaggerUIBundle(swaggerOptions)

  if (customOptions.oauth) {
    ui.initOAuth(customOptions.oauth)
  }

  if (customOptions.authAction) {
    ui.authActions.authorize(customOptions.authAction)
  }

  window.ui = ui

  // Custom UI
  var container = document.getElementsByClassName('schemes wrapper')[0];

  var input = document.createElement("input");
  input.type = "text";
  input.id = "username";
  input.value = username;
  container.prepend(input);

  input.onchange = function() {
    init(input.value);
  }
}

window.onload = onLoad;
