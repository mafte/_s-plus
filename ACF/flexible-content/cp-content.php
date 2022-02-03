<?php
//Get fields with $cp array or get_sub_field()
// var_dump($cp);
$html_anchor = '';
if ($cp->html_anchor) {
    $html_anchor = 'id="' . $cp->html_anchor . '"';
}
?>

<!-- ************************** CP-CONTENT  -->

<section <?php echo $html_anchor; ?> class="cp-content <?php echo $cp->class_css; ?>">

    <div class="container">
        <div class="row">
            <div class="col">
                <?php echo $cp->content; ?>
            </div>
        </div>
    </div>

</section>

<!--  CP-CONTENT ************************** -->