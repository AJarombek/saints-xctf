/*
 * Author: Andrew Jarombek
 * Date: 3/14/2017 - 6/2/2017
 * Global Javascript utility functions
 * Version 1.0 (OFFICIAL RELEASE) - 6/2/2017
 */

const FEEL_COLORS = {
    1: {color: 'rgba(204, 0, 0, .4)', coloralt: 'rgba(204, 0, 0, .6)', name: 'Terrible', class: 'terrible_feel'},
    2: {color: 'rgba(255, 51, 0, .4)', coloralt: 'rgba(255, 51, 0, .6)', name: 'Very Bad', class: 'very_bad_feel'},
    3: {color: 'rgba(204, 102, 0, .4)', coloralt: 'rgba(204, 102, 0, .6)', name: 'Bad', class: 'bad_feel'},
    4: {color: 'rgba(255, 153, 0, .4)', coloralt: 'rgba(255, 153, 0, .6)', name: 'Pretty Bad', class: 'pretty_bad_feel'},
    5: {color: 'rgba(255, 255, 51, .4)', coloralt: 'rgba(255, 255, 51, .6)', name: 'Mediocre', class: 'mediocre_feel'},
    6: {color: 'rgba(187, 187, 187, .4)', coloralt: 'rgba(187, 187, 187, .6)', name: 'Average', class: 'average_feel'},
    7: {color: 'rgba(115, 230, 0, .4)', coloralt: 'rgba(115, 230, 0, .6)', name: 'Fairly Good', class: 'fairly_good_feel'},
    8: {color: 'rgba(0, 153, 0, .4)', coloralt: 'rgba(0, 153, 0, .6)', name: 'Good', class: 'good_feel'},
    9: {color: 'rgba(0, 102, 0, .4)', coloralt: 'rgba(0, 102, 0, .6)', name: 'Great', class: 'great_feel'},
    10: {color: 'rgba(26, 26, 255, .4)', coloralt: 'rgba(26, 26, 255, .6)', name: 'Fantastic', class: 'fantastic_feel'}
};

// Get the HTTP GET URI Parameters
function get(name) {
    if (name = (new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
}

// To prevent HTML Injection
function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}