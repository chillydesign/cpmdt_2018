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
        <div class="alert alert-success">Votre booking a bien été enregistrée!</div>
    <?php elseif ( isset($_GET['problem'])  ) : ?>
        <div class="alert alert-danger">Une erreur s’est produite. Veuillez réessayer.</div>
    <?php endif; ?>



    <div class="inscription_field">
        <label for="no_people">Nombre de personne </label>
        <div class="field_content">
            <select id="no_people" name="no_people">
                <?php for ( $i = 1; $i <= $places_allowed ; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php }; ?>

            </select>
        </div>
    </div>


    <div class="inscription_field">
        <label for="last_name">Nom  </label>
        <div class="field_content">
            <input type="text" name="last_name" id="last_name" />
        </div>
    </div>
    <div class="inscription_field">
        <label for="first_name">Prénom  </label>
        <div class="field_content">
            <input type="text" name="first_name" id="first_name" />
        </div>
    </div>

    <div class="inscription_field">
        <label for="email">Email </label>
        <div class="field_content">
            <input type="name" name="email" id="email" />
        </div>
    </div>
    <div class="inscription_field">
        <label for="telephone">Téléphone  </label>
        <div class="field_content">
            <input type="text" name="telephone" id="telephone" />
        </div>
    </div>

    <?php // HIDDEN ACTION INPUT IS REQUIRED TO POST THE DATA TO THE CORRECT PLACE ?>
    <div class="inscription_field submit_group_button">
        <input type="submit" id="submit_booking_form" value="Envoyer">
        <input type="hidden" name="action" value="booking_form">
        <input type="hidden" name="agenda_id" value="<?php echo get_the_ID(); ?>">
        <input type="hidden" name="agenda_title" value="<?php echo get_the_title(); ?>">
        <div id="stopsubmit"></div>
    </div>
    <br><br>
    <p class="fillitall">Veuillez remplir tous les champs pour valider l'booking.</p>
</form>
