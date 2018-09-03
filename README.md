# istatapi
Istat Italian regions and provinces api for local db in Lumen (Laravel)

## How to use

**GET '/api/countries'**
- Get all countries 

**GET '/api/country/{code}**
- Get country object by code (es: IT, UK)

**GET '/api/regions**
- Get all regions of Italy

**GET '/api/region/{keyword}'**
- Search region using keyword: could be ISTAT code, name or string contained in name (Es: "tosc" or "toscana")

**GET '/api/region/{keyword}/provinces**
- Like the above one, but get all provinces of found region

**GET '/api/provinces**
- Get all provinces of Italy

**GET '/api/province/{keyword}**
- Search province using keyword: could be ISTAT code, name or string contained in name (Es: "mode" or "modena")

**GET '/api/province/{keyword}/cities**
- Like the above one, but get all cities (aka "Comuni") of found province

**GET '/api/cities**
- Get all comuni of Italy

**GET '/api/city/{keyword}'**
- Search city using keyword: could be ISTAT code, name or string contained in name (Es: "Quattr" or "Quattro Castella")

Good work!
