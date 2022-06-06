function cleanEvent(event) {
    event.preventDefault()
    event.stopImmediatePropagation()

    return event
}

function cleanForm(form, classInputs = 'resettable-input-JS', classCheckboxes = 'resettable-checkbox-JS') {
    console.log('Cleaning Form...');
    form.find(`.${classInputs}`).val('') // For input - select - textarea

    form.find(`input[type="checkbox"].${classCheckboxes}`).prop('checked', false)
}

/** AJAX REQUESTS DATA HELPER */
function extractData(response) {
    if(this.checkResponse(response)) {
        let parseData = this.parseData(response) // console.log(parseData);
        // return parseData.response.data

        if (parseData.hasOwnProperty('response') && parseData.response.data) {
            // console.log('Extract Data: ', parseData.response.data);
            return parseData.response.data
        }
    }

    return undefined
}

function checkResponse(response) {
    let data = this.parseData(response)

    if (data.hasOwnProperty('error')) {
        console.log(data.error)
        return false
    }

    if (data.hasOwnProperty('response')) {
        let dataController = data.response
        if (dataController.hasOwnProperty('errors')) {
            console.log(dataController.errors)
            return false
        }
    }        
    
    return true
}

function parseData(data, dataType = 'JSON') {
    return JSON.parse(data)
}

const WlHelper = {
    cleanEvent,
    cleanForm,
    extractData,
    checkResponse,
    parseData,
}

export default WlHelper