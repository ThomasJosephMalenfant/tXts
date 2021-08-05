'use strict';
// TODO Ajout sélecteur d'étape de la communauté pour différent pattern de célébration

// TODO Modifier la génération automatisée pour un découpage en 2 étapes
//      1) Bouton 1 Population des événements selon options idem actuel SANS attendees
//      2) Bouton 2 shuffle brasse attendees là où il trouve ? comme attendees

/*eslint-disable*/
var DateTime = luxon.DateTime;
var ScheduleList = [];

var SCHEDULE_CATEGORY = [
    'milestone',
    'task'
];

class MembresPool extends Array {
    brasser(input) {
        const tmp = [];
        input.forEach(element => {
            tmp.push(element);
        });
        chance.shuffle(tmp).forEach(element => {
            this.push(element);
        });
      return this ;
    }
}

function ScheduleInfo() {
    this.id = null;
    this.calendarId = null;

    this.title = null;
    this.body = null;
    this.isAllday = false;
    this.start = null;
    this.end = null;
    this.category = '';
    this.dueDateClass = '';

    this.color = null;
    this.bgColor = null;
    this.dragBgColor = null;
    this.borderColor = null;
    this.customStyle = '';

    this.isFocused = false;
    this.isPending = false;
    this.isVisible = true;
    this.isReadOnly = false;
    this.goingDuration = 0;
    this.comingDuration = 0;
    this.recurrenceRule = '';
    this.state = '';

    this.raw = {
        memo: '',
        hasToOrCc: false,
        hasRecurrenceRule: false,
        location: null,
        class: 'public', // or 'private'
        creator: {
            name: '',
            avatar: '',
            company: '',
            email: '',
            phone: ''
        }
    };
}

function generateNouvelleCeleb(calendar, ceMoment, titre, duration, lieu, pool, membresList, nbEquipe) {
    var schedule = new ScheduleInfo();

    schedule.id = chance.guid();
    schedule.calendarId = calendar.id ;

    schedule.title = titre ;
    schedule.body = '' // President de la célébration
    schedule.category = 'time' ;
    schedule.start = ceMoment.toFormat("yyyy-MM-dd'T'HH:mm':00'");
    schedule.end = ceMoment.plus({hours: duration}).toFormat("yyyy-MM-dd'T'HH:mm':00'");
    schedule.location = lieu ;
    schedule.attendees = pool.length >= nbEquipe 
        ? pool.splice(0, nbEquipe).join(", ") 
        : pool.brasser(membresList).splice(0,nbEquipe).join(", ") ;
    // schedule.recurrenceRule = chance.bool({likelihood: 20}) ? 'repeated events' : '';
    schedule.color = calendar.color;
    schedule.bgColor = calendar.bgColor;
    schedule.dragBgColor = calendar.dragBgColor;
    schedule.borderColor = calendar.borderColor;

    // schedule.raw.memo = chance.sentence();
    // schedule.raw.creator.name = 
    // schedule.raw.creator.avatar = chance.avatar();
    // schedule.raw.creator.company = chance.company();
    // schedule.raw.creator.email = chance.email();
    // schedule.raw.creator.phone = chance.phone();

    ScheduleList.push(schedule);
}

function generateSchedule(viewName, renderStart, renderEnd) {
    var jourParole = my_post['jourParole'] ?? "mardi"; 
    var jourMesse = my_post['jourMesse'] ?? "samedi" ;
    var nbEquipe = parseInt(my_post['nbmembre']) ?? 4 ;
    var membresTxt = my_post['pool'] ?? 'Bob&Bobinette, Gimli' ;
    var membresList = membresTxt.split(',').map(s => s.trim());
    var pool = new MembresPool ;
    pool.brasser(membresList);
    ScheduleList = [];

    if (viewName === "month") {
        const jourStart = DateTime.fromMillis(renderStart.getTime());
        var nbJours = DateTime.fromMillis(renderEnd.getTime()).diff(jourStart, 'days').days + 7;
        for (let index = 0; index <= nbJours ; index++) {
            const ceJour = jourStart.plus({days: index});
            const ceMomentParole = DateTime.local(ceJour.year, ceJour.month, ceJour.day, parseInt(my_post['heureParole'].split(":")[0]), parseInt(my_post['heureParole'].split(":")[1])) ;
            const ceMomentMesse = DateTime.local(ceJour.year, ceJour.month, ceJour.day, parseInt(my_post['heureMesse'].split(":")[0]), parseInt(my_post['heureMesse'].split(":")[1])) ;
            switch (ceJour.setLocale('fr').toFormat('EEEE')) {    
                case jourParole:
                    generateNouvelleCeleb(CalendarList[0], ceMomentParole, "Parole", 2, my_post["lieuParole"], pool, membresList, nbEquipe);
                    break;
            
                case jourMesse:
                    generateNouvelleCeleb(CalendarList[0], ceMomentMesse, "Eucharistie", 2, my_post["lieuMesse"], pool, membresList, nbEquipe);                
                    break;
    
                default:
                    break;
            }
        }
    }
}
