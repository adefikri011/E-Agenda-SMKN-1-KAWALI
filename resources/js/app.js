import 'tailwindcss';

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'select2';
import 'select2/dist/css/select2.css';
import 'select2-tailwindcss-theme/dist/select2-tailwindcss-theme-plain.css';

document.addEventListener('DOMContentLoaded', () => {
    $('#walikelas').select2({
        theme: 'tailwindcss-3',
        placeholder: 'Pilih Wali Kelas',
        allowClear: true,
        width: '100%',
    });
});
