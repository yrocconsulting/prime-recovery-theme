<?php
/**
 * Shared business facts and home page content.
 *
 * One source of truth for name, address, phone, products and FAQs so the
 * visible copy and the JSON-LD always say the same thing (entity consistency).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function prime_recovery_business() {
	return array(
		'name'        => 'Prime Recovery',
		'tagline'     => 'Partners in Patient Recovery',
		'description' => 'Prime Recovery is a home medical equipment provider based in Corcoran, Minnesota. We deliver and set up at-home recovery devices, including the NICE1 iceless cold + compression therapy system, for patients and the medical professionals who care for them across Minnesota and Wisconsin.',
		'street'      => '20175 County Road 50',
		'city'        => 'Corcoran',
		'region'      => 'MN',
		'postal'      => '55340',
		'country'     => 'US',
		'phone'       => '(651) 374-9026',
		'phone_e164'  => '+16513749026',
		'fax'         => '(612) 642-2526',
		'offices'     => array(
			array( 'city' => 'Duluth', 'region' => 'MN' ),
			array( 'city' => 'Bemidji', 'region' => 'MN' ),
			array( 'city' => 'Madison', 'region' => 'WI' ),
			array( 'city' => 'Green Bay', 'region' => 'WI' ),
		),
		// Replace with the real profile URLs before launch. Empty entries are skipped.
		'social'      => array(
			'facebook' => '',
			'linkedin' => '',
		),
		'years'       => '30+',
	);
}

/**
 * Site links the client asked to surface on the home page.
 * Paths point at pages that will be built after a design is chosen.
 */
function prime_recovery_links() {
	return array(
		'shop'      => array(
			'label' => 'Shop',
			'url'   => home_url( '/shop/' ),
			'blurb' => 'Order recovery devices and supplies for delivery.',
			'icon'  => 'cart',
		),
		'resources' => array(
			'label' => 'Resource Library',
			'url'   => home_url( '/resources/' ),
			'blurb' => 'How-to videos, recovery guides and injury info.',
			'icon'  => 'book',
		),
		'team'      => array(
			'label' => 'Meet the Team',
			'url'   => home_url( '/meet-the-team/' ),
			'blurb' => 'The technicians who deliver and support your recovery.',
			'icon'  => 'people',
		),
		'about'     => array(
			'label' => 'Our Mission',
			'url'   => home_url( '/about/' ),
			'blurb' => 'Why we bring the gold standard of care home.',
			'icon'  => 'heart',
		),
		'connect'   => array(
			'label' => 'Connect With Us',
			'url'   => home_url( '/contact/' ),
			'blurb' => 'Follow along, or set up a meeting with our team.',
			'icon'  => 'chat',
		),
	);
}

function prime_recovery_products() {
	return array(
		'nice1'      => array(
			'name'    => 'NICE1',
			'kicker'  => 'Cold + Compression Therapy System',
			'summary' => 'An iceless system that delivers long-lasting cold and programmable compression therapy. No more buying, storing and filling machines with ice multiple times a day.',
			'url'     => home_url( '/products/nice/' ),
			'cta'     => 'Discover iceless therapy',
			'image'   => 'nice1-overhead.jpg',
			'alt'     => 'Patient using the NICE1 iceless cold and compression wrap on his lower leg, with the NICE1 unit beside him',
		),
		'plasmaflow' => array(
			'name'    => 'PlasmaFlow',
			'kicker'  => 'Portable DVT Prevention',
			'summary' => 'An easy-to-use sequential compression system for home or clinical use to help prevent the onset of deep vein thrombosis (DVT).',
			'url'     => home_url( '/products/plasmaflow/' ),
			'cta'     => 'Learn about PlasmaFlow',
			'image'   => 'plasmaflow.jpg',
			'alt'     => 'PlasmaFlow tubeless compression cuffs on both calves',
		),
		'manaflexx'  => array(
			'name'    => 'ManaFlexx 2',
			'kicker'  => 'Muscle Stimulator',
			'summary' => 'The only NMES device designed to eliminate wires and standalone electrodes. Used to treat muscle atrophy due to lack of use or surgery.',
			'url'     => home_url( '/products/manaflexx2/' ),
			'cta'     => 'Learn about ManaFlexx 2',
			'image'   => 'manaflexx2.jpg',
			'alt'     => 'ManaFlexx 2 wireless muscle stimulator applied to the thigh',
		),
		'bracing'    => array(
			'name'    => 'Bracing',
			'kicker'  => 'Enovis / DJO',
			'summary' => 'Off-the-shelf and custom bracing solutions with fittings and education for patients and providers.',
			'url'     => home_url( '/products/bracing/' ),
			'cta'     => 'Explore bracing',
			'image'   => '',
			'alt'     => '',
		),
	);
}

/**
 * NICE1 feature list, from the current NICE1 product page.
 */
function prime_recovery_nice1_features() {
	return array(
		array( 'title' => 'Cooling without ice', 'text' => 'State-of-the-art technology delivers therapeutic cooling without ice. The most convenient way to apply cold therapy.' ),
		array( 'title' => 'Programmable compression', 'text' => 'Intermittent and constant compression improves the effectiveness of cold therapy and promotes healing.' ),
		array( 'title' => 'Smaller and lighter', 'text' => 'At 8 x 8 x 8 inches and 9 lbs, NICE1 is the smallest and lightest cold + compression device on the market.' ),
		array( 'title' => 'Simple touch screen', 'text' => 'An intuitive graphical touch screen makes NICE1 easy to operate at home.' ),
	);
}

function prime_recovery_testimonials() {
	return array(
		array(
			'quote'  => 'Not having to refill the machine with ice is incredibly convenient, especially when you’re recovering from surgery.',
			'author' => 'Laurenne Ross',
			'role'   => 'Olympic Skier',
		),
		array(
			'quote'  => 'My wife was sick of getting, storing and filling my old machine with ice. Not dealing with ice every 2 hours made everyone happier, and allowed me to rehab more often. Unit was cold, compressed great and was super easy to use.',
			'author' => 'Cam',
			'role'   => 'Patient',
		),
	);
}

/**
 * Plain-language answers that AI answer engines can quote directly.
 * Rendered on the page and mirrored in FAQPage JSON-LD.
 */
function prime_recovery_faqs() {
	return array(
		array(
			'q' => 'What is the NICE1 cold + compression therapy system?',
			'a' => 'NICE1 is an iceless cold + compression therapy device for recovery after injury or surgery. It delivers precise cold therapy without ice and programmable intermittent or constant compression in an 8 x 8 x 8 inch, 9 lb unit with a touch screen.',
		),
		array(
			'q' => 'Do I need to add ice to the NICE1?',
			'a' => 'No. NICE1 cools without ice, so there is no buying, storing or refilling ice every few hours during your recovery.',
		),
		array(
			'q' => 'How do I get a recovery device from Prime Recovery?',
			'a' => 'Prime Recovery works with your surgeon or medical provider. Once your device is ordered, a Prime Recovery technician delivers it and shows you how to use it at home. Call (651) 374-9026 with questions.',
		),
		array(
			'q' => 'Where does Prime Recovery serve patients?',
			'a' => 'Prime Recovery is based in Corcoran, Minnesota, with satellite offices in Duluth and Bemidji, Minnesota, and Madison and Green Bay, Wisconsin.',
		),
		array(
			'q' => 'Does Prime Recovery work with clinics and surgeons?',
			'a' => 'Yes. Prime Recovery partners with medical professionals to provide patients with recovery devices, bracing, delivery, setup and ongoing support, backed by more than 30 years of healthcare experience.',
		),
	);
}

/**
 * Asset URL helper.
 */
function prime_recovery_img( $file ) {
	return get_theme_file_uri( 'assets/img/' . $file );
}

/**
 * Small inline icon set (stroke icons, currentColor).
 */
function prime_recovery_icon( $name ) {
	$paths = array(
		'cart'     => '<circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h3l2.7 12.2a1 1 0 0 0 1 .8h9.6a1 1 0 0 0 1-.8L21 7H6"/>',
		'book'     => '<path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v17H6.5A2.5 2.5 0 0 0 4 21.5z"/><path d="M4 21.5A2.5 2.5 0 0 1 6.5 19H20v3H6.5"/>',
		'people'   => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><circle cx="17" cy="9" r="2.5"/><path d="M16 14.2a5 5 0 0 1 5.5 5.8"/>',
		'heart'    => '<path d="M12 20s-7.5-4.6-9.3-9.4C1.5 7.3 3.6 4 7 4c2 0 3.5 1.1 5 3 1.5-1.9 3-3 5-3 3.4 0 5.5 3.3 4.3 6.6C19.5 15.4 12 20 12 20z"/>',
		'chat'     => '<path d="M21 12a8 8 0 0 1-11.6 7.1L4 20.5l1.4-5A8 8 0 1 1 21 12z"/>',
		'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'snow'     => '<path d="M12 2v20M4.9 6.5l14.2 11M19.1 6.5 4.9 17.5M9 3.5l3 2.5 3-2.5M9 20.5l3-2.5 3 2.5"/>',
		'pulse'    => '<path d="M2 12h4l3-8 4 16 3-8h6"/>',
		'feather'  => '<path d="M20 4c-8 0-14 6-14 14v2"/><path d="M6 14h7M9 10h7"/>',
		'touch'    => '<rect x="5" y="2" width="14" height="20" rx="2.5"/><path d="M10 18h4"/>',
		'truck'    => '<path d="M2 6h11v10H2zM13 10h5l3 3v3h-8z"/><circle cx="6" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>',
		'stetho'   => '<path d="M6 3v6a5 5 0 0 0 10 0V3"/><path d="M11 14v2a5 5 0 0 0 10 0v-2"/><circle cx="21" cy="12" r="1.5"/>',
		'home'     => '<path d="M3 11 12 3l9 8"/><path d="M5 10v10h14V10"/>',
		'phone'    => '<path d="M5 3h4l2 5-2.5 1.5a11 11 0 0 0 6 6L16 13l5 2v4a2 2 0 0 1-2 2A17 17 0 0 1 3 5a2 2 0 0 1 2-2z"/>',
		'pin'      => '<path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
		'check'    => '<path d="m4 12 5 5L20 6"/>',
		'x'        => '<path d="M6 6l12 12M18 6 6 18"/>',
		'brace'    => '<path d="M8 2v6c0 2-2 3-2 6s2 4 2 8M16 2v6c0 2 2 3 2 6s-2 4-2 8"/><path d="M8 9h8M8 15h8"/>',
		'facebook' => '<path d="M15 3h-2.5A4.5 4.5 0 0 0 8 7.5V10H5.5v4H8v7h4v-7h3l.5-4H12V7.8c0-.5.4-.8.8-.8H15z"/>',
		'linkedin' => '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 10v7M8 7v.01M12 17v-4a2 2 0 0 1 4 0v4M12 10v7"/>',
	);
	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}
	return '<svg class="icon icon-' . esc_attr( $name ) . '" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $name ] . '</svg>';
}
