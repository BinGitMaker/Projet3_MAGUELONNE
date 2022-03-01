/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

window.bootstrap = require('bootstrap');

const btn = document.getElementById('btn-scroll');

btn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth',
    });
});

window.onscroll = () => {
    if (window.scrollY > 350) {
        btn.classList.add('show');
    } else {
        btn.classList.remove('show');
    }
};
