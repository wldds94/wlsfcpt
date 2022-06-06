/**
 * Manage global libraries like jQuery or THREE from the webpack.mix.js file
 */
import $ from "jquery";

class WlsfcptCrono {

    constructor() {
        this.init()
    }

    init() {
        console.log('WlsfcptCrono Initialized...');

        window.addEventListener("pageshow", function (event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });
    }
}

export default WlsfcptCrono