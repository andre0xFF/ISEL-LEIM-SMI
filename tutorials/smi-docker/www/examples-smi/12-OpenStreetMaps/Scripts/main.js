import { 
    getXmlHttpObject } from './modules/ajax.js';

import { 
    changeSelectDistrict, 
    changeSelectCounty,
    changeSelectPostalCode } from './modules/forms.js';

import { 
    initMap, 
    resetMap,
    calcRoute,
    updateDistrictOnMap, 
    updateCountyOnMap,
    updatePostalCodeOnMap } from './modules/maps.js.php';

// ajax.js
window.getXmlHttpObject                 = getXmlHttpObject;

// forms.js
window.changeSelectDistrict             = changeSelectDistrict;
window.changeSelectCounty               = changeSelectCounty;
window.changeSelectPostalCode           = changeSelectPostalCode;

// maps.js(.php)
window.initMap                          = initMap;
window.calcRoute                        = calcRoute;
window.resetMap                         = resetMap;
window.updateDistrictOnMap              = updateDistrictOnMap;
window.updateCountyOnMap                = updateCountyOnMap;
window.updatePostalCodeOnMap            = updatePostalCodeOnMap;