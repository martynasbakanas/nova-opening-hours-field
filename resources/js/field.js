Nova.booting((app) => {
    app.component('index-nova-opening-hours-field', require('./components/Nova/IndexField').default)
    app.component('detail-nova-opening-hours-field', require('./components/Nova/DetailField').default)
    app.component('form-nova-opening-hours-field', require('./components/Nova/FormField').default)
})
