function getFullAddress(place) {
    const addressComponents = place.address_components;
    let streetNumber = '';
    let streetName = '';
    let city = '';
    let state = '';
    let postalCode = '';
    let country = '';

    addressComponents.forEach(component => {
        const types = component.types;

        // Get street number (if available)
        if (types.includes('street_number')) {
            streetNumber = component.long_name;
        }

        // Get street name (if available)
        if (types.includes('route')) {
            streetName = component.long_name;
        }

        // Get city (locality)
        if (types.includes('locality')) {
            city = component.long_name;
        }

        // Get state (administrative_area_level_1)
        if (types.includes('administrative_area_level_1') && (component.long_name !== city) ) {
            state = component.long_name;
        }

        // Get postal code
        if (types.includes('postal_code')) {
            postalCode = component.long_name;
        }

        // Get country
        if (types.includes('country')) {
            country = component.long_name;
        }
    });

    const parts = [];

    // Only add street name and number if both exist
    if (streetName) {
        parts.push(`${streetName}${streetNumber ? ` ${streetNumber}` : ''}`);
    }

    // Add city if exists
    if (city) {
        parts.push(city);
    }

    // Add state if exists
    if (state) {
        parts.push(state);
    }

    // Add postal code if exists
    if (postalCode) {
        parts.push(postalCode);
    }

    // Add country if exists
    if (country) {
        parts.push(country);
    }

    const fullAddress = parts.join(', ');
    return [fullAddress.trim(), city];
}

export default function initializeAutocomplete(inputId, form) {
    const input = document.getElementById(inputId);
    let autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener("place_changed", onPlaceChange);
    function onPlaceChange() {
        const place = autocomplete.getPlace();
        const addressResult = getFullAddress(place);
        form.value[inputId] =  addressResult[0];
        form.value[inputId === 'address_from' ? 'city_from' : 'city_to'] =  addressResult[1];
    }
}
