/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
//import './styles/app.css';
import './styles/assets/css/style.css'
import './styles/assets/js/main';
import '.styles/assets/styles/assets/vendor/aos/aos.css';
import './styles/assets/styles/assets/vendor/bootstrap/css/bootstrap.min.css';
import './styles/assets/styles/assets/vendor/bootstrap-icons/bootstrap-icons.css';
import './styles/assets/styles/assets/vendor/boxicons/css/boxicons.min.css';
import './styles/assets/styles/assets/vendor/glightbox/css/glightbox.min.css';
import './styles/assets/styles/assets/vendor/remixicon/remixicon.css'
import './styles/assets/vendor/swiper/swiper-bundle.min.css';


// start the Stimulus application
import './bootstrap';

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
//require('bootstrap/js/dist/popover');
import 'bootstrap/dist/css/bootstrap.min.css';
import "assets/styles/assets/vendor/purecounter/purecounter_vanilla.js";
import "assets/styles/assets/vendor/aos/aos.js";
import "assets/styles/assets/vendor/bootstrap/js/bootstrap.bundle.min.js";
import "assets/styles/assets/vendor/glightbox/js/glightbox.min.js";
import "assets/styles/assets/vendor/isotope-layout/isotope.pkgd.min.js";
import "assets/styles/assets/vendor/swiper/swiper-bundle.min.js";
