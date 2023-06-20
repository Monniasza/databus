#!/usr/bin/php
# Dataset Version - the DataId
<?php
error_reporting( E_ALL | E_STRICT );
require_once("function.php");
init();

?>
## Version

A Databus Version is one specific version of a Databus artifact (artifacts = version-independent, abstract datasets). 


Please note that the fuzzy word `dataset` is disambiguated on the Databus, as it could mean:
1. artifact (see [here](https://dbpedia.gitbook.io/databus/model/model/artifact)): the abstract concept of a dataset (e.g. the DBpedia Label dataset, [https://databus.dbpedia.org/dbpedia/generic/labels/](https://databus.dbpedia.org/dbpedia/generic/labels/)).
2. **version (this page, see below)**: a specific version of a dataset (e.g. DBpedia Label dataset of Sep 1st, 2022, [https://databus.dbpedia.org/dbpedia/generic/labels/2022.09.01](https://databus.dbpedia.org/dbpedia/generic/labels/2022.09.01)).
3. distribution (see [here](https://dbpedia.gitbook.io/databus/model/model/distribution)): the bag of files of a specific version (e.g. the download location: [https://downloads.dbpedia.org/repo/dbpedia/generic/labels/2022.09.01/](https://downloads.dbpedia.org/repo/dbpedia/generic/labels/2022.09.01/))   



<?php
$section="version" ;
$sectionExampleURI="https://databus.dbpedia.org/janni/onto_dep_projectx/dbpedia-ontology/2021-12-06";
$owl=
'databus:Version  a owl:Class ;
    rdfs:label "Version"@en ;
    rdfs:comment "Dataset Version"@en ; 
    rdfs:subClassOf dcat:Dataset , dataid:Dataset ;
    rdfs:isDefinedBy <https://dataid.dbpedia.org/databus#> .
';

$shacl='<#dataset-exists>
	a sh:NodeShape ;
	sh:targetNode databus:Version ;
	sh:property [
	  sh:path [ sh:inversePath rdf:type ] ;
	  sh:minCount 1 ;
	  sh:maxCount 1 ;
	  sh:message "Exactly one subject with an rdf:type of databus:Version must occur."@en ;
	] ;
	sh:property [
		sh:path [ sh:inversePath rdf:type ] ;
		  sh:nodekind sh:IRI ;
		sh:pattern "/[a-zA-Z0-9\\\\-_]{4,}/[a-zA-Z0-9\\\\-_\\\\.]{1,}/[a-zA-Z0-9\\\\-_\\\\.]{1,}/[a-zA-Z0-9\\\\-_\\\\.]{1,}$" ;
		sh:message "IRI for databus:Version must match /USER/GROUP/ARTIFACT/VERSION , |USER|>3"@en ;
  ] . ';


$example='"@type": "databus:Version",';

$context='"Version": 	"databus:Version" ';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>

## 1. General Metadata

### title

A name given to the resource.

<?php
$owl='dct:title
	rdfs:label "Title"@en ;
	rdfs:comment "A name given to the resource."@en ;
	rdfs:isDefinedBy <http://purl.org/dc/terms/> ;
	rdfs:range rdfs:Literal ;
	rdfs:subPropertyOf <http://purl.org/dc/elements/1.1/title> .';

$shacl='<#title-dataid>
	a sh:NodeShape ;
	sh:targetClass databus:Version ;
	sh:property [
		sh:path dct:title ;
		sh:severity sh:Violation ;
		sh:message "Required property dct:title MUST occur exactly once without language tag."@en ;
        sh:qualifiedValueShape [ sh:datatype xsd:string ] ;
		sh:qualifiedMinCount 1 ;
		sh:qualifiedMaxCount 1 ;		
    ] ;
        sh:property [
		sh:path dct:title ;
		sh:severity sh:Violation ;
		sh:message "Besides the required occurance of dct:title without language tag, dct:title can be used with language tag, but each language only once."@en ;
		sh:uniqueLang true ;
	] . ';

$example='"title": "DBpedia Ontology",';

$context='duplicate';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>


### abstract

TODO autogenerated from the first 200 chars of `description`.


<?php


$owl='dct:abstract
	rdfs:label "Abstract"@en ;
	rdfs:comment "A summary of the resource."@en ;
	rdfs:isDefinedBy <http://purl.org/dc/terms/> ;
	rdfs:subPropertyOf <http://purl.org/dc/elements/1.1/description>, dct:description .';

$shacl='<#abstract-dataid>
	a sh:NodeShape ;
    sh:targetClass databus:Version ;
    sh:property [
	    sh:path dct:abstract ;
	    sh:severity sh:Violation ;
	    sh:message "Required property dct:abstract MUST occur at least once without language tag."@en ;
	    sh:qualifiedValueShape [ sh:datatype xsd:string ] ;
		sh:qualifiedMinCount 1 ;
		sh:qualifiedMaxCount 1 ;	
	];
	sh:property [
		sh:path dct:abstract ;
	    sh:severity sh:Violation ;
	    sh:message "Besides the required occurance of dct:abstract without language tag, each occurance of dct:abstract must have less than 300 characters and each language must occure only once. "@en ;
	    sh:uniqueLang true;
	    sh:maxLength 300 ;
	] . ';

$example='"abstract": "Registered a version of the DBpedia Ontology into my account",';

$context='duplicate';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);

?>


### description

Markdown allowed. The first 200 chars will be used as an abstract. 

<?php
$owl='dct:description
	dct:description "Description may include but is not limited to: an abstract, a table of contents, a graphical representation, or a free-text account of the resource."@en ;
	rdfs:comment "An account of the resource."@en ;
	rdfs:isDefinedBy <http://purl.org/dc/terms/> ;
	rdfs:label "Description"@en ;
	rdfs:subPropertyOf <http://purl.org/dc/elements/1.1/description> .';

$shacl='<#description-dataid>
	a sh:NodeShape ;
    sh:targetClass databus:Version ;
    sh:property [
		sh:path dct:description ;
		sh:severity sh:Violation ;
		sh:message "Required property dct:description MUST occur exactly once without language tag."@en ;
        sh:qualifiedValueShape [ sh:datatype xsd:string ] ;
		sh:qualifiedMinCount 1 ;
		sh:qualifiedMaxCount 1 ;		
    ] ;
        sh:property [
		sh:path dct:description ;
		sh:severity sh:Violation ;
		sh:message "Besides the required occurance of dct:description without language tag, dct:title can be used with language tag, but each language only once."@en ;
		sh:uniqueLang true ;
	] . ';

$example='"description": "Registered a version of the DBpedia Ontology into my account. Using markdown:\n  1. This is the version used in [project x](http://example.org) as a stable snapshot dependency\n  2. License was checked -> CC-BY\n",';

$context='duplicate';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>


### publisher

The agent, person or organisation responsible for publishing this Databus version's metadata (**not the files itself**)

<?php
$owl='dct:publisher
	dcam:rangeIncludes dct:Agent ;
	rdfs:comment "An entity responsible for making the resource available."@en ;
	rdfs:isDefinedBy <http://purl.org/dc/terms/> ;
	rdfs:label "Publisher"@en ;
	rdfs:subPropertyOf <http://purl.org/dc/elements/1.1/publisher> .';

$shacl='<#has-publisher>
	a sh:PropertyShape ;
  sh:targetClass databus:Version ;
	sh:severity sh:Violation ;
	sh:message "Required property dct:publisher MUST occur exactly once and have URI/IRI as value"@en ;
	sh:path dct:publisher;
	sh:minCount 1 ;
	sh:maxCount 1 ;
	sh:nodeKind sh:IRI .';

$example='"publisher": TODO';

$context='"publisher": {
      "@id": "dct:publisher",
      "@type": "@id"
    }';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>

## 2. Legal, Provenance & Attribution

Three main features are included in the model:

* Automation of licensing. To describe datasets a license URIs is required. In most cases these URIs provide a human-only HTML description. License URIs from our affiliate project [DALICC](https://dalicc.net) are machine-actionable and machines can compare licenses and check for compatibility and obligations in an automated manner.  
* Provenance chains. Once datasets are registered with any Databus, provenance relations can be added to the graph and link to the source data the current version `was Derived From`. Combined with licenses, this enables to track back input sources and dependencies and transitively accumulate all licensing information. 
* Attribution. Most dataset metadata originally comes from unstructured, non-machine readable places such as HTML Websites. This attribution information needs to be captured initially on the Databus, whenever data metadata is first lifted into the Databus model. 

**Note:** Entered metadata is signed with the users private key or on behalt of the user by the Databus to avoid tempering with this information (see `proof`). This is an extra measure to secure against falsification of the legal implications of the metadata.     

### license

* Usage of DALICC License URIs is highly recommended ([library](https://www.dalicc.net/license-library/)). 
* License is set at the dataid:Dataset node, but is always valid for all distributions, which is also reflected by signing the tractate.
* context.jsonld contains `"@context":{"@base": null },` to prevent creating local IRIs.

<?php
$owl='dct:license
	rdfs:label "License"@en ;
	rdfs:comment "A legal document giving official permission to do something with the resource."@en ;
	dct:description "Recommended practice is to identify the license document with a URI. If this is not possible or feasible, a literal value that identifies the license may be provided."@en ;
	dcam:rangeIncludes dct:LicenseDocument ;
	rdfs:isDefinedBy <http://purl.org/dc/terms/> ;
	rdfs:subPropertyOf <http://purl.org/dc/elements/1.1/rights>, dct:rights .';

$shacl='<#has-license>
	a sh:PropertyShape ;
	sh:targetClass void:Version ;
	sh:severity sh:Violation ;
	sh:message "Required property dct:license MUST occur exactly once and have URI/IRI as value"@en ;
	sh:path dct:license;
	sh:minCount 1 ;
	sh:maxCount 1 ;
	sh:nodeKind sh:IRI .';

$example='"license": "http://creativecommons.org/licenses/by/4.0/",';

$context='"license": {
      "@context":{"@base": null },
      "@id": "dct:license",
      "@type": "@id"
    }';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>



### wasDerivedFrom

Imports the Provenance Ontology. Linking should be done between Dataset versions. 

<?php
$owl='prov:wasDerivedFrom a owl:ObjectProperty ;
    rdfs:isDefinedBy <http://www.w3.org/ns/prov-o#> ;
    rdfs:label "wasDerivedFrom" ;
    prov:definition "A derivation is a transformation of an entity into another, an update of an entity resulting in a new one, or the construction of a new entity based on a pre-existing entity."@en ;
    rdfs:domain prov:Entity ;
    rdfs:range prov:Entity .
';

$shacl='';

$example='"wasDerivedFrom": "https://databus.dbpedia.org/dbpedia/generic/labels/2022.09.01",';

$context='"wasDerivedFrom":	{
	"@id": "prov:wasDerivedFrom", 
	"@type": "@id"
}';


table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>

### attribution

Capturing information about attribution serves these purposes:

* enable citations in academic context
* fulfill license obligations such as CC-BY. Note that most open licenses only grant you the specified freedoms, if you properly fulfill the obligations such as attribution.  

The field attribution is:
* optional (can be omitted)
* multi-valued (can have more than one entry, e.g. one for attributing the paper, one for attributing the publishing organisation)
* multi-type (can have variety of different formats, which are listed below)


#### Publication Link
??

#### Bibtex
```
{}
```

#### Markdown
[title](uri), [attribution](url), [license](license-url)
 
#### © Copyright
© Intergovernmental Panel on Climate Change 2014


<?php
$owl='dataid:attribution a owl:DataTypeProperty; 
	rdfs:label "attribution"@en ;
	rdfs:comment "TODO"@en ;
	rdfs:domain databus:Artifact, databus:Version, databus:Group ;
	rdfs:range xsd:string ;
	rdfs:isDefinedBy <http://dataid.dbpedia.org/ns/core#> . ';

$shacl='';

$example='"attribution": "TODO",';

$context='"attribution":	{"@id": "dataid:attribution"}';


table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>

## 3. Structural Metadata

`group`, `artifact`, `version`, `hasVersion` are the main properties used to structure all entries on the Databus for querying and retrieval. The most basic query here is to retrieve the latest version for each artifact in some group or to check, whether there is a new version available for one artifact.   


### group

<?php #TODO single value restriction??
$owl=
'databus:group rdf:type owl:ObjectProperty ;
    rdfs:label "group"@en ;
    rdfs:comment "Refers to a group or collection of resources."@en ;
    rdfs:domain databus:Version ;
    rdfs:range databus:Group ;
    rdfs:isDefinedBy <https://dataid.dbpedia.org/databus#> .
';

$shacl='<#has-group>
	a sh:PropertyShape ;
	sh:targetClass databus:Version ;
	sh:severity sh:Violation ;
	sh:message "Required property databus:group MUST occur exactly once AND be of type IRI AND must match /USER/GROUP , |USER|>3"@en ;
	sh:path databus:group ;
	sh:minCount 1 ;
	sh:maxCount 1 ;
	sh:nodeKind sh:IRI ;
  sh:pattern "/[a-zA-Z0-9\\\\-_]{4,}/[a-zA-Z0-9\\\\-_\\\\.]{1,}$" .

<#is-group-uri-correct>
	a sh:NodeShape;
	sh:targetClass databus:Version ;
	sh:sparql [
		sh:message "Dataset URI must contain the group URI of the associated group." ;
		sh:prefixes databus: ;
    sh:select """
			SELECT $this ?group
			WHERE {
				$this <http://dataid.dbpedia.org/databus#group> ?group .
        FILTER(!strstarts(str($this), str(?group)))
			}
			""" ;
	] .';

$example='"group": "https://databus.dbpedia.org/janni/onto_dep_projectx",';

$context='duplicate';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>


### artifact 


<?php
autonote();


$owl=
'databus:artifact a rdf:ObjectProperty ;
    rdfs:label "artifact"@en ;
    rdfs:comment "Specifies an artifact associated with a dataset in the DataID vocabulary."@en ;
    rdfs:domain databus:Version ;
    rdfs:range databus:Artifact ;
    rdfs:isDefinedBy <https://dataid.dbpedia.org/databus#> .';

$shacl='<#has-artifact>
	a sh:PropertyShape ;
	sh:targetClass databus:Version ;
	sh:severity sh:Violation ;
	sh:message "Required property databus:artifact MUST occur exactly once AND be of type IRI AND must match /USER/GROUP/ARTIFACT , |USER|>3"@en ;
	sh:path databus:artifact ;
	sh:minCount 1 ;
	sh:maxCount 1 ;
	sh:nodeKind sh:IRI  ;
  sh:pattern "/[a-zA-Z0-9\\\\-_]{4,}/[a-zA-Z0-9\\\\-_\\\\.]{1,}/[a-zA-Z0-9\\\\-_\\\\.]{1,}$" .

<#is-artifact-uri-correct>
	a sh:NodeShape;
	sh:targetClass databus:Version ;
	sh:sparql [
		sh:message "Version URI must contain the artifact URI of the associated artifact." ;
		sh:prefixes databus: ;
    sh:select """
			SELECT $this ?artifact
			WHERE {
				$this <http://dataid.dbpedia.org/databus#artifact> ?artifact .
        FILTER(!strstarts(str($this), str(?artifact)))
			}
			""" ;
	] .';

$example='"artifact": "https://databus.dbpedia.org/janni/onto_dep_projectx/dbpedia-ontology",';

$context='duplicate';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>


### hasVersion

Note: see section versioning above. 

<?php
$owl='dct:hasVersion
	dct:description "Changes in version imply substantive changes in content rather than differences in format. This property is intended to be used with non-literal values. This property is an inverse property of Is Version Of."@en ;
	rdfs:comment "A related resource that is a version, edition, or adaptation of the described resource."@en ;
	rdfs:isDefinedBy <http://purl.org/dc/terms/> ;
	rdfs:label "Has Version"@en ;
	rdfs:subPropertyOf <http://purl.org/dc/elements/1.1/relation>, dct:relation .';

$shacl='<#has-hasVersion-dataset>
	a sh:PropertyShape ;
	sh:targetClass databus:Version ;
	sh:severity sh:Violation ;
	sh:message "Required property dct:hasVersion MUST occur exactly once AND be of type Literal"@en ;
	sh:path dct:hasVersion ;
	sh:minCount 1 ;
	sh:maxCount 1 ;
	sh:nodeKind sh:Literal .';

$example='"hasVersion": "2021-12-06",';

$context='"hasVersion": 	{"@id": "dct:hasVersion"}';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>

### distribution
<?php
$owl='dcat:distribution
  a owl:ObjectProperty ;
  rdfs:label "distribution"@en ;
  rdfs:comment "An available distribution of the dataset."@en ;
  rdfs:isDefinedBy <http://www.w3.org/TR/vocab-dcat/> ;
  rdfs:domain dcat:Dataset ;
  rdfs:range dcat:Distribution ;
  rdfs:subPropertyOf dct:relation ;
  skos:definition "An available distribution of the dataset."@en .';

$shacl='<#has-distribution>
	a sh:PropertyShape ;
	sh:targetClass databus:Version ;
	sh:severity sh:Violation ;
	sh:message "Required property dcat:distribution MUST occur at least once AND have URI/IRI as value"@en ;
	sh:path dcat:distribution;
	sh:minCount 1 ;
	sh:nodeKind sh:IRI .';

$example='"distribution": [{
          		"@id": "https://databus.dbpedia.org/janni/onto_dep_projectx/dbpedia-ontology/2021-12-06#ontology--DEV_type=parsed_sorted.nt",
          		"@type": "databus:Part",
          		"file": "https://databus.dbpedia.org/janni/onto_dep_projectx/dbpedia-ontology/2021-12-06/ontology--DEV_type=parsed_sorted.nt",
          		"format": "nt",
          		"compression": "none",
          		"downloadURL": "https://akswnc7.informatik.uni-leipzig.de/dstreitmatter/archivo/dbpedia.org/ontology--DEV/2021.07.09-070001/ontology--DEV_type=parsed_sorted.nt",
          		"byteSize": "4439722",
          		"sha256sum": "b3aa40e4a832e69ebb97680421fbeff968305931dafdb069a8317ac120af0380",
          		"hasVersion": "2021-12-06",
          		"dcv:type": "parsed_sorted"
              }]';

$context='"distribution": {
      "@type": "@id",
      "@id": "dcat:distribution"
}';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>

## 4. Other Metadata

### issued

Date of formal issuance of the resource using `xsd:dateTime`.

<?php
$owl='dct:issued
	rdfs:label "Date Issued"@en ;
	rdfs:comment "Date of formal issuance of the resource."@en ;
	dct:description "Recommended practice is to describe the date, date/time, or period of time as recommended for the property Date, of which this is a subproperty."@en ;
	dct:issued "2000-07-11"^^<http://www.w3.org/2001/XMLSchema#date> ;
	rdfs:isDefinedBy <http://purl.org/dc/terms/> ;
	rdfs:range rdfs:Literal ;
	rdfs:subPropertyOf <http://purl.org/dc/elements/1.1/date>, dct:date .';

$shacl='<#has-issued>
	a sh:PropertyShape ;
	sh:targetClass void:Version ;
	sh:severity sh:Violation ;
	sh:message "Required property dct:issued MUST occur exactly once AND have xsd:dateTime as value"@en ;
	sh:path dct:issued;
	sh:minCount 1 ;
	sh:maxCount 1 ;
	sh:datatype xsd:dateTime .';

$example='"issued": "2021-12-06T11:34:17Z",';

$context='"issued": {
      "@id": "dct:issued",
      "@type": "xsd:dateTime"
    }';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>

### modified

Note: dct:modified is *always* set by the Databus on post.

<?php
$owl='dct:modified
	rdfs:label "Date Modified"@en ;
	rdfs:comment "Date on which the resource was changed."@en ;
	dct:description "Recommended practice is to describe the date, date/time, or period of time as recommended for the property Date, of which this is a subproperty."@en ;
	rdfs:isDefinedBy <http://purl.org/dc/terms/> ;
	rdfs:range rdfs:Literal ;
	rdfs:subPropertyOf <http://purl.org/dc/elements/1.1/date>, dcterms:date .';

$shacl='<#has-modified>
	a sh:PropertyShape ;
	sh:targetClass void:Version ;
	sh:severity sh:Violation ;
	sh:message "Required property dct:modified MUST occur exactly once AND have xsd:dateTime as value"@en ;
	sh:path dct:modified;
	sh:minCount 1 ;
	sh:maxCount 1 ;
	sh:datatype xsd:dateTime .';

$example='"modified": "%NOW%",';

$context='"modified": {
      "@id": "dct:modified",
      "@type": "xsd:dateTime"
    }';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>





### proof

<?php
$owl=
'sec:proof a owl:ObjectProperty; 
	rdfs:label "has cryptographic proof"@en ;
	rdfs:comment "The proof property is used to associate a proof with a graph of information. The proof property is typically not included in the canonicalized graph that is then digested, and digitally signed."@en ;
	#rdfs:domain  ;
	#rdfs:range  ;
	rdfs:isDefinedBy <https://w3id.org/security#> . 
';


$shacl='';

$example='"proof": {
  "@type": "dataid:DatabusTractateV1",
  "signature": "d61a05ca4810367f361f17500304a168aab27a3119c93a18c00bce1775dfd6b1"
}';

$context='"signature":	{"@id": "sec:signature"},
"proof":	{"@id": "sec:proof"}';

table($section,$sectionExampleURI,$owl,$shacl,$example,$context);
?>
