// The district select has changed
export function changeSelectDistrict() {
    console.log( "forms#changeSelectDistrict()" );
    
    updateDistrictOnMap( "Lisboa" );
}

// The county select has changed
export function changeSelectCounty() {
    console.log( "forms#changeSelectCounty() called" );
    
    updateCountyOnMap( "Cascais" );
}

// The postal code select has changed
export function changeSelectPostalCode() {
    console.log( "forms#changeSelectPostalCode() called" );
    
    updatePostalCodeOnMap( "2785" );
}
