/**
 * Manage global libraries like jQuery or THREE from the webpack.mix.js file
 */
import $ from "jquery";
import WlsfcptFilter from "./archive/filters"
import WlsfcptDimensions from "./layout/dimensions"
import WlsfcptCrono from "./layout/crono"
import WlsfcptSingle from "./single/single"

$(function() {
    // $('#users-list-table').DataTable({})
    console.log('SayFarm App Initialized..')

    const filter = new WlsfcptFilter()
    const dimensions = new WlsfcptDimensions()
    const crono = new WlsfcptCrono()
    const single = new WlsfcptSingle()
})