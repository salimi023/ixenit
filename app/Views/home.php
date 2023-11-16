<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>app/Libraries/w3.css" />
    <!-- DataTables style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>app/Libraries/datatables/datatables.min.css" />
    <title>Ixenit - Teszt</title>
    <style>
    #content {
        width: 80%;
        margin: 50px auto 0 auto
    }

    .asterisk {
        color: red
    }

    .form-group {
        border: solid thin #d8d8d8;
        padding: 10px;
        margin-bottom: 10px
    }

    .alert {
        color: red
    }
    </style>
</head>

<body>
    <div id="wrapper">
        <div id="content" class="w3-container">
            <div id="title" class="w3-panel w3-blue w3-padding w3-xlarge w3-card-4">Felhasználók</div>
            <div id="buttons_container" class="w3-container">
                <button id="add_user" class="w3-btn w3-orange w3-round w3-margin-top w3-left">Új Felhasználó</button>
                <button id="delete_user" class="w3-btn w3-red w3-round w3-margin-top w3-right">Felhasználó
                    törlése</button>
            </div>
            <div id="table_container" class="w3-container">
                <div id="status_msg" class="w3-panel w3-red w3-round w3-card-4 w3-padding w3-large">Jelenleg nincs
                    mentett felhasználó!</div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="user_modal" class="w3-modal">
        <div class="w3-modal-content w3-animate-opacity">
            <div class="w3-container">
                <span id="close_modal" class="w3-button w3-display-topright">&times;</span>
                <div id="modal_title" class="w3-row w3-xlarge w3-padding"></div>
                <div class="w3-row w3-padding"><small>A <span class="asterisk">*-al</span> jelölt mezők kitöltése
                        kötelező!</small></div>
                <div id="modal_content" class="w3-row w3-padding">
                    <span id="validationStatus" class="w3-hide"></span>
                    <span id="base_url" class="w3-hide"><?php echo base_url(); ?></span>
                    <form>
                        <div class="w3-row form-group">
                            <h3>Név</h3>
                            <div class="w3-margin-bottom">
                                <label for="last_name">Vezetéknév<span class="asterisk">*</span></label>
                                <input type="text" class="w3-input w3-border valid" id="last_name" name="last_name" />
                                <span class="alert"></span>
                            </div>
                            <div class="w3-margin-bottom">
                                <label for="first_name">Keresztnév<span class="asterisk">*</span></label>
                                <input type="text" class="w3-input w3-border valid" id="first_name" name="first_name"
                                    required />
                                <span class="alert"></span>
                            </div>
                        </div>
                        <div class="w3-row form-group">
                            <div class="w3-margin-bottom">
                                <h3>Állandó lakcím</h3>
                                <label for="zip_code">Irányítószám<span class="asterisk">*</span></label>
                                <input class="w3-input w3-border valid" id="zip_code" name="zip_code" type="text"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="4" />
                                <span class="alert"></span>
                            </div>
                            <div class="w3-margin-bottom">
                                <label for="address">Cím<span class="asterisk">*</span></label>
                                <input class="w3-input w3-border valid" type="text" id="address" name="address" />
                                <span class="alert"></span>
                            </div>
                            <div class="w3-margin-bottom">
                                <label for="city">Város<span class="asterisk">*</span></label>
                                <input class="w3-input w3-border valid" type="text" id="city" name="city" />
                                <span class="alert"></span>
                            </div>
                        </div>
                        <div class="w3-row form-group">
                            <div class="w3-margin-bottom">
                                <h3>Ideiglenes lakcím</h3>
                                <label for="temp_zip_code">Irányítószám<span class="asterisk temp_title w3-hide">*</span></label>
                                <input class="w3-input w3-border temp" id="temp_zip_code" name="temp_zip_code"
                                    type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                    maxlength="4" />
                                <span class="alert"></span>
                            </div>
                            <div class="w3-margin-bottom">
                                <label for="temp_address">Cím<span class="asterisk temp_title w3-hide">*</span></label>
                                <input class="w3-input w3-border temp" type="text" id="temp_address"
                                    name="temp_address" />
                                <span class="alert"></span>
                            </div>
                            <div class="w3-margin-bottom">
                                <label for="temp_city">Város<span class="asterisk temp_title w3-hide">*</span></label>
                                <input class="w3-input w3-border temp" type="text" id="temp_city" name="temp_city" />
                                <span class="alert"></span>
                            </div>
                        </div>
                        <div class="w3-row form-group">
                            <div id="phone" class="w3-margin-bottom">
                                <h4>Telefon<span class="asterisk">*</span></h4>
                                <div id="phone_numbers" class="w3-margin-bottom">
                                    <div class="w3-row">
                                        <div class="w3-twothird">
                                            <input class="w3-input w3-border valid" name="phone_number" type="text"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                maxlength="11" />
                                            <span class="alert"></span>
                                        </div>
                                    </div>
                                </div>
                                <button class="w3-btn w3-blue w3-round" id="add_phone_number">Új telefonszám</button>
                            </div>
                        </div>
                        <div class="w3-row form-group">
                            <div id="emails_container" class="w3-margin-bottom">
                                <h4>E-mail<span class="asterisk">*</span></h4>
                                <div id="emails" class="w3-margin-bottom">
                                    <div class="w3-row">
                                        <div class="w3-twothird">
                                            <input class="w3-input w3-border valid" name="email" type="email" />
                                            <span class="alert"></span>
                                        </div>
                                    </div>
                                </div>
                                <button class="w3-btn w3-blue w3-round" id="add_email">Új e-mail</button>
                            </div>
                        </div>
                        <input type="submit" class="w3-btn w3-green w3-round w3-margin-top w3-margin-bottom send"
                            name="save_user" id="save_user" value="Mentés" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>app/Libraries/jquery.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>app/Libraries/datatables/datatables.min.js"></script>
    <!-- Validation -->
    <script src="<?php echo base_url(); ?>app/JS/validation.js"></script>
    <!-- Modal -->
    <script src="<?php echo base_url(); ?>app/JS/modal.js"></script>
    <!-- Add User -->
    <script src="<?php echo base_url(); ?>app/JS/add_user.js"></script>
</body>

</html>