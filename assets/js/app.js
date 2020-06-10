/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';
const $ = require('jquery');
global.$ = global.jQuery = $;
require('bootstrap');

$(document).on('click', 'button#input_city', function(){
    let that = $(this);
    let data = $('#input_city').val();
    $.ajax({
        url: that.data('url'),
        type: 'POST',
        dataType: 'json',
        data: {
            'input_city': data
        },
        success: function (data)
        {
            if (data === "Cette ville n\'existe pas" || data.main === undefined){
                $('span.ajax-results').html(data);
            } else {
                $('span.ajax-results').html(function () {
                    return "Il fait " + data.main.temp + "°C à " + data.name;
                });
            }
        }
    });
    return false;
});

