<?php

global $places_left;
// only let people book as many seats to not oversell
$places_allowed = 5;
if ($places_left <= 5 ) {
    $places_allowed =  $places_left;
}
?>



<form class="inscription_form" action="<?php echo  esc_url( admin_url('admin-post.php') );?>" method="post" >



    <?php if (  isset( $_GET['success']) ) : ?>
        <div class="alert alert-success">Votre réservation a bien été enregistrée!</div>
    <?php elseif ( isset($_GET['problem'])  ) : ?>
        <div class="alert alert-danger">Une erreur s’est produite. Veuillez réessayer.</div>
    <?php endif; ?>



    <div class="inscription_field">
        <label for="no_people">Nombre de personnes *</label>
        <div class="field_content">
            <select required id="no_people" name="no_people">
                <?php for ( $i = 1; $i <= $places_allowed ; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php }; ?>

            </select>
        </div>
    </div>


    <div class="inscription_field">
        <label for="last_name">Nom *</label>
        <div class="field_content">
            <input required type="text" name="last_name" id="last_name" />
        </div>
    </div>
    <div class="inscription_field">
        <label for="first_name">Prénom *</label>
        <div class="field_content">
            <input required type="text" name="first_name" id="first_name" />
        </div>
    </div>

    <div class="inscription_field">
        <label for="email">Email *</label>
        <div class="field_content">
            <input required type="text" name="email" id="email" />
        </div>
    </div>

    <div class="inscription_field">
        <label for="email_confirmation">Confirmation Courriel *</label>
        <div class="field_content">
            <input class="prevent_pasting" required type="text" name="email_confirmation" id="email_confirmation" />
        </div>
    </div>

    <div class="inscription_field">
        <label for="telephone">Téléphone * </label>
        <div class="field_content">
            <input required type="text" name="telephone" id="telephone" />
        </div>
    </div>


    <?php $ordinals = ['zeroth', 'first', 'deuxième', 'troisième', 'quatrième', 'cinquième']; ?>
    <?php for ( $i = 2; $i <= $places_allowed ; $i++) { ?>
        <?php $classes = array();
        for ($j= $i; $j <= $places_allowed ; $j++) {
             array_push($classes,  ' booking_people_' . $j );
        }; ?>
        <div class=" extra_people_field <?php echo implode($classes, ' '); ?>">
        <div class="inscription_field">
            <label for="last_name_<?php echo $i; ?>">Nom de la <?php echo $ordinals[$i]; ?> personne</label>
            <div class="field_content">
                <input type="text" name="last_name_<?php echo $i; ?>" id="last_name_<?php echo $i; ?>" />
            </div>
        </div>
        <div class="inscription_field">
            <label for="first_name_<?php echo $i; ?>">Prénom de la <?php echo $ordinals[$i]; ?> personne</label>
            <div class="field_content">
                <input type="text" name="first_name_<?php echo $i; ?>" id="first_name_<?php echo $i; ?>" />
            </div>
        </div>
        </div>
    <?php }; ?>





    <?php // HIDDEN ACTION INPUT IS REQUIRED TO POST THE DATA TO THE CORRECT PLACE ?>
    <div class="inscription_field submit_group_button">
            <label for="email">&nbsp;</label>
        <div class="field_content">
            <input type="submit" id="submit_booking_form" value="Envoyer">
            <input type="hidden" name="action" value="booking_form">
            <input type="hidden" name="agenda_id" value="<?php echo get_the_ID(); ?>">
            <div id="stopsubmit"></div>
            <br><br>
            <p class="fillitall">Veuillez remplir tous les champs pour valider la réservation.</p>
        </div>

    </div>

</form>
