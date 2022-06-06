/**
 * Manage global libraries like jQuery or THREE from the webpack.mix.js file
 */
import $ from "jquery";

class Tabber {
	constructor() {
		this.el = $(document);

		this.listeners();
		this.init();
	}

	init() {
		// eslint-disable-next-line no-console
		console.info( 'Tabber Initialized' );
	}

	listeners() {
		if ( this.el ) {
            if ( $("ul.nav-tabs > li") ) { 
                // let tabs = $("ul.nav-tabs > li")
                this.el.on('click', 'ul.nav-tabs > li', this.switchTab)
            } 

            if ($("ul.subnav-tabs > li") != null) {
                // var subTabs = $("ul.subnav-tabs > li");
                this.el.on('click', 'ul.subnav-tabs > li', this.switchSubTab)
            }
		}
	}

    switchTab(event) {
		event.preventDefault(); // console.log(event); // console.log($(this)); // console.log('Switching Tab...');

		// var clickedTab = event.currentTarget;
		let link = $(this).find('a')
		let anchor = link.attr('href')
		let memory = $(this).attr('data-memory')
        let subnav = $(`ul.subnav-tabs li`) // console.log(subnav);
        let subtab = false
        if (subnav.length) subtab = $('ul.subnav-tabs li a[href="' + memory + '"]').parent('li')
		// let subtab = $(`ul.subnav-tabs li a[href=${memory}]`) ? $(`ul.subnav-tabs li a[href=${memory}]`).parent('li') : false
		// console.log(subtab); console.log(link); console.log(anchor);

		$("ul.nav-tabs li.active").removeClass('active')
		$(".tab-pane.active").removeClass('active')

		$(this).addClass('active')
		$(anchor).addClass('active')

        if (subtab) subtab.trigger('click')

		// const $aside = $('#wrapRoot').find('.layout-aside-contents');
		// let activated = $aside.find('.aside-tab.active')
		// activated.removeClass('active')
		// if ($(this).hasClass('calendar')) {
		// 	console.log('Open Aside Calendar Handled');

		// 	// Refresh Calendar
		// 	$("ul.subnav-tabs > li.sync-calendar a").trigger('click')
		// 	// scheduler.updateView();

		// 	// Active Calendar
      	// 	// activated.removeClass('active')
		// 	$('.layout-aside-contents .aside-calendar').addClass('active');

		// 	// Minicalendar
		// 	scheduler.setCurrentView();

		// 	// Hide the user-panel-button-container in aside clock-container
		// 	$('.clock-container .user-panel-button-container').addClass('hidden')
		// } else {
		// 	if ($(this).hasClass('dashboard')) {
		// 		console.log('Trigging refreshing stats...');
		// 		$('.list-dashboard a')[0].click()
		// 		// console.log('Trigging refreshing stats var 2...');
		// 		// $('.list-dashboard a')[0].trigger('click')
		// 	}
		// 	// activated.removeClass('active')
		// 	$('.layout-aside-contents .aside-calendar').removeClass('active');
		// 	$('.layout-aside-contents .aside-user-admin').addClass('active');

		// 	// Display the user-panel-button-container in aside clock-container
		// 	$('.clock-container .user-panel-button-container').removeClass('hidden')
		// }
		
	}

    switchSubTab(event) {
		// console.log('Switching Subtab...');
		event.preventDefault(); // console.log(event); console.log(event.currentTarget); console.log(event.target);

        let link = $(this).find('a')
        let anchor = link.attr('href')
        let menuDataTab = $(this).parent('ul').attr('data-tab')

        let menu = $(`ul.nav-tabs li[data-subtab=${menuDataTab}]`)
        menu.attr('data-memory', anchor)
        // console.log(link); console.log(anchor);

        $("ul.subnav-tabs li.active").removeClass('active')
        $(".subtab.active").removeClass('active')

        $(this).addClass('active')
        $(anchor).addClass('active')

		// if (!$(this).hasClass('sync-calendar') && !$(this).hasClass('export-calendar-pdf') && !$(this).hasClass('export-calendar-png')) {
		// 	// console.log($(this));
		// 	// var clickedTab = event.currentTarget;
		// 	let link = $(this).find('a')
		// 	let anchor = link.attr('href')
		// 	let menuDataTab = $(this).parent('ul').attr('data-tab')

		// 	let menu = $(`ul.nav-tabs li[data-subtab=${menuDataTab}]`)
		// 	menu.attr('data-memory', anchor)
		// 	// console.log(link); console.log(anchor);

		// 	$("ul.subnav-tabs li.active").removeClass('active')
		// 	$(".subtab.active").removeClass('active')

		// 	$(this).addClass('active')
		// 	$(anchor).addClass('active')
		// }

		// if($(this).hasClass('calendar-active-sync')) scheduler.updateView(); // $('li.sync-calendar a').trigger('click')
	}

	// elClick( e ) {
	// 	e.target.classList.add( 'text-light-grey' );
	// 	e.target.addEventListener( 'transitionend', ( event ) =>
	// 		'color' === event.propertyName
	// 			? event.target.classList.remove( 'text-light-grey' )
	// 			: ''
	// 	);
	// }
}

export default Tabber;