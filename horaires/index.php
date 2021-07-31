<?php
ob_start();

if ( filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING) ) { 
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Calendrier test DEMO</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css">
        <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css">
        <link rel="stylesheet" type="text/css" href="./tui/dist/tui-calendar.css">
        <link rel="stylesheet" type="text/css" href="./tui/app/css/default.css">
        <link rel="stylesheet" type="text/css" href="./tui/app/css/icons.css">
        <script>
            <?php
            print 'var my_post = [];
                ' ;

            foreach ($_POST as $key => $value) {
                print 'my_post["' . $key . '"] = "' . filter_input(INPUT_POST,$key,FILTER_SANITIZE_STRING) . '" ;
                    ' ; 
            }
            ?>
        </script>
    </head>
    <body>
        <div id="menu">
            <span class="dropdown">
                <button id="dropdownMenu-calendarType" class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                    <i id="calendarTypeIcon" class="calendar-icon ic_view_month" style="margin-right: 4px;"></i>
                    <span id="calendarTypeName">Dropdown</span>&nbsp;
                    <i class="calendar-icon tui-full-calendar-dropdown-arrow"></i>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-calendarType">
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-monthly">
                            <i class="calendar-icon ic_view_month"></i>Mois
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weekly">
                            <i class="calendar-icon ic_view_week"></i>Semaine
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks2">
                            <i class="calendar-icon ic_view_week"></i>2 semaines
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks3">
                            <i class="calendar-icon ic_view_week"></i>3 semaines
                        </a>
                    </li>
                </ul>
            </span>
            <span id="menu-navi">
                <button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">Aujourd'hui</button>
                <button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev">
                    <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm move-day" data-action="move-next">
                    <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm move-day" data-action="populate">
                    <i class="calendar-icon ic-down" data-action="populate"></i>
                </button>
            </span>
            <span id="renderRange" class="render-range"></span>
        </div>
        <div id="calendar"></div>
            <!-- TODO : Ajouter façon de laisser des notes dans le bas -->
        <!-- <form><label for="notes">Notes :</label><textarea id="notes" name="notes" placeholder="Notes pour le mois..."></textarea></form> -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>
        <script src="https://uicdn.toast.com/tui.time-picker/v2.0.3/tui-time-picker.min.js"></script>
        <script src="https://uicdn.toast.com/tui.date-picker/v4.0.3/tui-date-picker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/luxon/2.0.1/luxon.min.js" integrity="sha512-bI2nHaBnCCpELzO7o0RB58ULEQuWW9HRXP/qyxg/u6WakLJb6wz0nVR9dy0bdKKGo0qOBa3s8v9FGv54Mbp3aA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chance/1.0.13/chance.min.js"></script>
        <script src="./tui/dist/tui-calendar.js"></script>
        <script src="./tui/app/js/data/calendars.js"></script>
        <script src="./tui/app/js/data/schedules.js"></script>
        <!-- <script src="./js/theme/dooray.js"></script> -->
        <script src="./tui/app/js/app.js"></script>
    </body>
    </html>
<?php
} else {
    ?>
    <!DOCTYPE html>
	<html>
	<head>
        <meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
		<link rel="apple-touch-icon" sizes="180x180" href="../icones/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="32x32" href="../icones/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="../icones/favicon-16x16.png">
		<link rel="stylesheet" href="./horaires.css">
 		<title>Planification</title>
	</head>
	<body>
		<div class="centrement">
			<div>
				<form method="post" autocomplete="off">
                    <fieldset>
                        <legend>Communautée</legend>
                        <div>
                            <label for="comm">Nom :</label>
                            <input type="text" id="comm" name="comm" placeholder="Exemple : STU1, NDF4...">
                        </div>
                        <div>
                            <label for="nbmembre">Nombre par équipe :</label>
                            <input type="number" id="nbmembre" name="nbmembre" min="3" max="6" value="4"> 
                        </div>
                        <div>
                            <label for="pool">Frères et soeurs :</label>
                            <textarea id="pool" name="pool" placeholder="Exemple : Gimli, Aragorn & Arwen..." ></textarea>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Parole</legend>
                        <div>
                            <label for="jourParole">Jour célébration parole :</label>
                            <select id="jourParole" name="jourParole">
                                <option value="mardi">Mardi</option>
                                <option value="mercredi">Mercredi</option>
                                <option value="jeudi">Jeudi</option>
                            </select>
                        </div>
                        <div>
                            <label for="heureParole">Heure de la Parole :</label>
                            <input type="time" id="heureParole" name="heureParole" value="19:45">
                        </div>
                        <div>
                            <label for="lieuParole">Lieu de la Parole :</label>
                            <input type="text" id="lieuParole" name="lieuParole" placeholder="Exemple : Srmq, St-Ignace...">
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Eucharistie</legend>
                        <div>
                            <label for="jourMesse">Jour de l'Eucharistie :</label>
                            <select id="jourMesse" name="jourMesse">
                                <option value="samedi">Samedi</option>
                                <option value="Dimanche">Dimanche</option>
                            </select>
                        </div>
                        <div>
                            <label for="heureMesse">Heure de l'Eucharistie :</label>
                            <input type="time" id="heureMesse" name="heureMesse" value="19:45">
                        </div>
                        <div>
                            <label for="lieuMesse">Lieu de l'Eucharistie :</label>
                            <input type="text" id="lieuMesse" name="lieuMesse" placeholder="Exemple : Srmq, St-Ignace...">
                        </div>
                    </fieldset>
                    <br>
                    <input id="data" name="data" type="hidden" value="1">
					<input type="submit" value="Envoyer">
				</form>
			</div>
		</div>
	</body>
	</html>
    <?php
}
ob_end_flush();
?>