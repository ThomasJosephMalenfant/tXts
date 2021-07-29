'use strict';

/*eslint-disable*/
var DateTime = luxon.DateTime;
var ScheduleList = [];

var SCHEDULE_CATEGORY = [
    'milestone',
    'task'
];

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

function generateTime(schedule, ceJour, nbHeureDuration) {
    //FIXME : utilisation merdique de moment.js pour raison de difficulté de formatage d'output de luxon.DateTime
    //              - Trouver définition de objet schedule
    //              - Formater luxon.toFormat() en fonction de input demandé pour propriétés .start et .end 
    var startDate = moment(ceJour.toMillis())
    var endDate = moment(ceJour.plus({hours: nbHeureDuration}).toMillis());
    var diffDate = endDate.diff(startDate, 'days');

    schedule.category = 'time';

    startDate.hours(19);
    startDate.minutes(45);
    schedule.start = startDate.toDate();

    endDate = moment(startDate);

    schedule.end = endDate.add(2, 'hour').toDate();

}

function generateNames() {
    var names = [];
    var i = 0;
    var length = chance.integer({min: 1, max: 10});

    for (; i < length; i += 1) {
        names.push(chance.name());
    }

    return names;
}

function generateNouvelleCeleb(calendar, ceJour, titre, renderStart, renderEnd) {
    var schedule = new ScheduleInfo();

    schedule.id = chance.guid();
    schedule.calendarId = calendar.id ;

    schedule.title = titre ;
    schedule.body = titre ;
    // schedule.isReadOnly = chance.bool({likelihood: 20});
    // schedule.start = ceJour.toString();
    // schedule.end = ceJour.plus({hours: 2}).toString();
    generateTime(schedule, ceJour, 2);
    // schedule.isPrivate = chance.bool({likelihood: 10});
    // schedule.location = chance.address();
    schedule.attendees = chance.bool({likelihood: 70}) ? generateNames() : [];
    // schedule.recurrenceRule = chance.bool({likelihood: 20}) ? 'repeated events' : '';
    // schedule.state = chance.bool({likelihood: 20}) ? 'Free' : 'Busy';
    schedule.color = calendar.color;
    schedule.bgColor = calendar.bgColor;
    schedule.dragBgColor = calendar.dragBgColor;
    schedule.borderColor = calendar.borderColor;

    // schedule.raw.memo = chance.sentence();
    // schedule.raw.creator.name = chance.name();
    // schedule.raw.creator.avatar = chance.avatar();
    // schedule.raw.creator.company = chance.company();
    // schedule.raw.creator.email = chance.email();
    // schedule.raw.creator.phone = chance.phone();

    // if (chance.bool({ likelihood: 20 })) {
    //     var travelTime = chance.minute();
    //     schedule.goingDuration = travelTime;
    //     schedule.comingDuration = travelTime;
    // }

    ScheduleList.push(schedule);
}

function generateSchedule(viewName, renderStart, renderEnd) {
    var jourParole = "mardi" ; 
    var jourMesse = "samedi" ;    
    ScheduleList = [];

    if (viewName === "month") {
        const jourStart = DateTime.fromMillis(renderStart.getTime());
        var nbJours = DateTime.fromMillis(renderEnd.getTime()).diff(jourStart, 'days').days;
        for (let index = 0; index < nbJours ; index++) {
            const ceJour = jourStart.plus({days: index});
            switch (ceJour.setLocale('fr').toFormat('EEEE')) {
                case jourParole:
                    generateNouvelleCeleb(CalendarList[0], ceJour,"Parole");
                    break;
            
                case jourMesse:
                    generateNouvelleCeleb(CalendarList[0], ceJour,"Eucharistie");                
                    break;
    
                default:
                    break;
            }
        }
        console.log(ScheduleList);
    }
}
