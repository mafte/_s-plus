function flInit() {

    /** Field flexible content name */
    fl_field_main_name = 'page_builder';

    $fl_field_main = document.querySelector('[data-name="' + fl_field_main_name + '"]');
    $fl_container = document.querySelector('.fl__container');
    $fl_content = document.querySelector('.fl__content');
    $fl_search_field = document.querySelector('#fl-search');
    $fl_actions_items = document.querySelectorAll('.fl__actions-item');

    url_active_theme = $fl_container.getAttribute('data-url-theme');
    fl_data_key = $fl_field_main.getAttribute('data-key');

    /** Get layout-names from 'page_builder' flexible-content field */
    $tmpl_popup = $fl_field_main.querySelector(':scope .tmpl-popup');
    $layout_info = fl_get_layout_meta($tmpl_popup);

    /** Fill container component in 'fl__content' */
    $content_html = '';
    $layout_info.forEach(el => {
        $content_html = $content_html + fl_card_cp_html(el);
    })

    $fl_content.innerHTML = $content_html;


    document.addEventListener('click', (e) => {
        let $target = e.target;

        if ($target.closest('[data-name="page_builder"]') && $target.dataset.name == 'add-layout') {

            /* Hide popup ACF */
            document.querySelector('.acf-tooltip').style.display = 'none';
            $fl_container.classList.add('show--pop-up');

            setTimeout(() => {
                $fl_search_field.focus();
                $fl_search_field.click();
            }, 200)

            if ($target.classList.contains('acf-icon')) {
                $target_parent_layout = $target.closest('.layout');
                $fl_container.setAttribute('data-row-id', $target_parent_layout.getAttribute('data-id'))
            }
        }

        /** Add eventListener to cards */

        if ($target.closest('.fl-card') || $target.classList.contains('fl-card')) {
            e.preventDefault();

            fl_add_component($target);
        }

        if ($target.closest('.fl__actions-item') || $target.classList.contains('fl__actions-item')) {

            $fl_actions_items.forEach(el => {
                el.classList.toggle('active');
            })


            let data_column = '';
            if ($target.closest('.fl__actions-item')) {
                data_column = $target.closest('.fl__actions-item').getAttribute('data-value');
            }



            $fl_content.setAttribute('data-columns', data_column);

        }

    })
}


function fl_get_layout_meta($el) {
    let tempDiv = document.createElement('div');
    tempDiv.innerHTML = $el.innerHTML;

    let $layouts = tempDiv.querySelectorAll(":scope a[data-layout]");
    let layouts_names = [];

    $layouts.forEach(el_layout => {
        layouts_names.push({
            name: el_layout.getAttribute('data-layout'),
            min: el_layout.getAttribute('data-min'),
            max: el_layout.getAttribute('data-max'),
            title: el_layout.textContent
        });
    })

    return layouts_names;
}

function fl_add_component($target) {

    let layout_name;
    if ($target.closest('.fl-card')) {
        layout_name = $target.closest('.fl-card').getAttribute('data-fl-layout');
    }

    let before_el = jQuery('[data-name="' + fl_field_main_name + '"] .values > [data-id="' + $fl_container.getAttribute('data-row-id') + '"]');

    if ($fl_container.getAttribute('data-row-id') === null || $fl_container.getAttribute('data-row-id') === '') {
        before_el = false;
    }

    $fl_field = acf.getField(fl_data_key);
    $fl_field.add({
        layout: layout_name,
        before: before_el
    })

    $fl_container.classList.remove('show--pop-up');

    //Reset data-attribute
    $fl_container.setAttribute('data-row-id', '');
}


document.addEventListener('DOMContentLoaded', function () {

    flInit();

    var items_origin_close = document.querySelectorAll(
        "[data-popup-dest] .button-close, [class*='data-popup-dest--'] .button-close, [class*='data-popup-dest--'] .button-close a"
    );

    items_origin_close.forEach(function (element) {
        element.addEventListener("click", function (e) {
            e.preventDefault();
            document
                .querySelectorAll("[data-popup-dest], [class*='data-popup-dest--']")
                .forEach(function (el) {
                    el.classList.remove("show--pop-up");
                });
        });
    });

    /* Cerrar modal si se hace click fuera de los elementos hijos */
    let items_dest = document.querySelectorAll("[data-popup-dest], [class*='data-popup-dest--']");

    items_dest.forEach(function (element) {
        element.addEventListener("click", function (e) {
            if (e.target === element) {
                e.preventDefault();
                e.target.classList.remove("show--pop-up");
            }
        });
    })

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            var popupElement = document.querySelector('[data-popup-dest]');

            if (popupElement) {
                $fl_container.classList.remove("show--pop-up");
            }
        }
    });

    $fl_cards = $fl_content.querySelectorAll('.fl-card');

    $fl_search_field.addEventListener('input', function () {
        const searchTerm = $fl_search_field.value.toLowerCase();
        console.log('Hello');

        $fl_cards.forEach(card => {
            const cardText = card.textContent.toLowerCase();
            if (cardText.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });


})

function fl_format_component_name(input) {
    // Paso 1: Eliminar 'cp_'
    const step1 = input.replace('cp_', '');

    // Paso 2: Reemplazar '_' con espacios
    const step2 = step1.replace(/_/g, ' ');

    // Paso 3: Convertir la primera letra en mayúscula
    const step3 = step2.charAt(0).toUpperCase() + step2.slice(1);

    return step3;
}

function fl_card_cp_html(layout) {
    layout_name_image = layout.name.replace(/_/g, "-");
    layout_name = fl_format_component_name(layout.name);
    url_image = url_active_theme + '/ACF/flexible-content/screens' + `/${layout_name_image}.jpg`;

    return `<a href="#" data-fl-layout="${layout.name}" data-min="${layout.min}" data-max="${layout.max}" class="fl-card">
    <div class="fl-card__img-wrp">
        <img src="${url_image}" class="fl-card__img" width="550" height="310">
    </div>
    <div class="fl-card__title-wrp">
        <h2 class="fl-card__title">${layout.title}</h2>
    </div>
</a>`;
}