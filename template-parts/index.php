<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package _s_plus
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

<main id="primary" class="site-main">


    <div class="container">
        <div class="row">
            <div class="col">
                <?php

                // echo sp_get_img__resp('large', 83, 'Optional');

                ?>


            </div>
        </div>
        <div class="row cols-24">
            <div class="col">
                <div class="box-green">

                </div>
            </div>
            <div class="col">
                <div class="box-green">

                </div>
            </div>
        </div>
        <div class="row cols-24">
            <div class="col">
                <div class="box-blue">

                </div>
            </div>
            <div class="col">
                <div class="box-blue">

                </div>
            </div>
            <div class="col">
                <div class="box-blue">

                </div>
            </div>
        </div>

        <div class="row cols-24">
            <div class="col">
                <div class="box-red">

                </div>
            </div>
            <div class="col">
                <div class="box-red">

                </div>
            </div>
            <div class="col">
                <div class="box-red">

                </div>
            </div>
            <div class="col">
                <div class="box-red">

                </div>
            </div>
        </div>
        <h2 class="fs-px">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem laboriosam suscipit accusantium architecto officia aliquid reprehenderit ipsam fugiat a. Placeat obcaecati, eum perferendis aut veritatis earum iusto autem deserunt libero!
            Error dolorum commodi enim corrupti consectetur expedita optio iste eius quisquam labore cum maiores ipsam, beatae perspiciatis laboriosam nostrum illo aut et. Nesciunt nemo beatae, quod saepe recusandae nam repellendus.
            Tempora perspiciatis aut provident, voluptatum expedita dignissimos fugit. Suscipit id dolorem temporibus eius, ullam eaque odit, accusantium, explicabo debitis repellat illo doloremque deleniti. Deleniti asperiores sequi qui numquam aspernatur adipisci.</h2>
        <div id="section-one" class="row cols-24 cols-w-400 scroll-margin">
            <div class="col">
                <div class="box-red">

                </div>
            </div>
            <div class="col">
                <div class="box-green">

                </div>
            </div>
            <div class="col">
                <div class="box-red">

                </div>
            </div>
            <div class="col">
                <div class="box-blue">

                </div>
            </div>
            <div class="col">
                <div class="box-red">

                </div>
            </div>
        </div>

        <?php
        // Tamaño de imagen correcto, id de imagen correcto
        // echo sp_get_img__resp('full', 83, 'Optional');
        // // Tamaño de imagen incorrecto, id de imagen correcto
        // echo sp_get_img__resp('esto-falso', 83, 'Optional');
        // // Tamaño de imagen correcto, id de imagen incorrecto
        // echo sp_get_img__resp('medium', 833, 'Optional');
        // // Tamaño de imagen incorrecto, id de imagen incorrecto
        // echo sp_get_img__resp('esto-falso', 833, 'Optional');



        ?>

        <section id="form">
            <form>
                <h2>Form elements</h2>

                <!-- Search -->
                <label for="search">Search</label>
                <input type="search" id="search" name="search" placeholder="Search" class="">

                <!-- Text -->
                <label for="text">Text</label>
                <input type="text" id="text" name="text" placeholder="Text" class="">
                <small>Curabitur consequat lacus at lacus porta finibus.</small>

                <!-- Select -->
                <label for="select">Select</label>
                <select id="select" name="select" required="" class="">
                    <option value="" selected="">Select…</option>
                    <option>…</option>
                </select>

                <!-- File browser -->
                <label for="file">File browser
                    <input type="file" id="file" name="file">
                </label>

                <!-- Range slider control -->
                <label for="range">Range slider
                    <input type="range" min="0" max="100" value="50" id="range" name="range">
                </label>

                <!-- States -->
                <div class="grid">
                    <label for="valid">
                        Valid
                        <input type="text" id="valid" name="valid" placeholder="Valid" aria-invalid="false" class="">
                    </label>
                    <label for="invalid">
                        Invalid
                        <input type="text" id="invalid" name="invalid" placeholder="Invalid" aria-invalid="true" class="">
                    </label>
                    <label for="disabled">
                        Disabled
                        <input type="text" id="disabled" name="disabled" placeholder="Disabled" disabled="">
                    </label>
                </div>

                <div class="grid">

                    <!-- Date-->
                    <label for="date">Date
                        <input type="date" id="date" name="date" class="">
                    </label>

                    <!-- Time-->
                    <label for="time">Time
                        <input type="time" id="time" name="time" class="">
                    </label>

                    <!-- Color-->
                    <label for="color">Color
                        <input type="color" id="color" name="color" value="#0eaaaa">
                    </label>

                </div>

                <div class="grid">

                    <!-- Checkboxes -->
                    <fieldset>
                        <legend><strong>Checkboxes</strong></legend>
                        <label for="checkbox-1">
                            <input type="checkbox" id="checkbox-1" name="checkbox-1" checked="">
                            Checkbox
                        </label>
                        <label for="checkbox-2">
                            <input type="checkbox" id="checkbox-2" name="checkbox-2">
                            Checkbox
                        </label>
                    </fieldset>

                    <!-- Radio buttons -->
                    <fieldset>
                        <legend><strong>Radio buttons</strong></legend>
                        <label for="radio-1">
                            <input type="radio" id="radio-1" name="radio" value="radio-1" checked="">
                            Radio button
                        </label>
                        <label for="radio-2">
                            <input type="radio" id="radio-2" name="radio" value="radio-2">
                            Radio button
                        </label>
                    </fieldset>

                    <!-- Switch -->
                    <fieldset>
                        <legend><strong>Switches</strong></legend>
                        <label for="switch-1">
                            <input type="checkbox" id="switch-1" name="switch-1" role="switch" checked="">
                            Switch
                        </label>
                        <label for="switch-2">
                            <input type="checkbox" id="switch-2" name="switch-2" role="switch">
                            Switch
                        </label>
                    </fieldset>

                </div>

                <!-- Buttons -->
                <input type="reset" value="Reset" onclick="event.preventDefault()">
                <input type="submit" value="Submit" onclick="event.preventDefault()">

            </form>
        </section>

    </div>
</main><!-- #main -->

<?php

get_footer();
