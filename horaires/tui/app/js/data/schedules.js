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

function generateNames() {
    var names = [];
    var i = 0;
    var length = chance.integer({min: 1, max: 10});

    for (; i < length; i += 1) {
        names.push(chance.name());
    }

    return names;
}

function generateNouvelleCeleb(calendar, ceMoment, titre, duration) {
    var schedule = new ScheduleInfo();

    schedule.id = chance.guid();
    schedule.calendarId = calendar.id ;

    schedule.title = titre ;
    // schedule.body = titre ;
    schedule.category = 'time' ;
    schedule.start = ceMoment.toFormat("yyyy-MM-dd'T'HH:mm':00'");
    schedule.end = ceMoment.plus({hours: duration}).toFormat("yyyy-MM-dd'T'HH:mm':00'");
    // schedule.location = chance.address();
    schedule.attendees = chance.bool({likelihood: 70}) ? generateNames() : [];
    // schedule.recurrenceRule = chance.bool({likelihood: 20}) ? 'repeated events' : '';
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

    ScheduleList.push(schedule);
}

function generateSchedule(viewName, renderStart, renderEnd) {
    var jourParole = my_post['jourParole'] ; 
    var jourMesse = my_post['jourMesse'] ?? "samedi" ;    
    ScheduleList = [];

    if (viewName === "month") {
        const jourStart = DateTime.fromMillis(renderStart.getTime());
        var nbJours = DateTime.fromMillis(renderEnd.getTime()).diff(jourStart, 'days').days;
        for (let index = 0; index < nbJours ; index++) {
            const ceJour = jourStart.plus({days: index});
            const ceMomentParole = DateTime.local(ceJour.year, ceJour.month, ceJour.day, parseInt(my_post['heureParole'].split(":")[0]), parseInt(my_post['heureParole'].split(":")[1])) ;
            const ceMomentMesse = DateTime.local(ceJour.year, ceJour.month, ceJour.day, 19, 45) ;
            switch (ceJour.setLocale('fr').toFormat('EEEE')) {    
                case jourParole:
                    generateNouvelleCeleb(CalendarList[0], ceMomentParole, "Parole", 2);
                    break;
            
                case jourMesse:
                    generateNouvelleCeleb(CalendarList[0], ceMomentMesse, "Eucharistie");                
                    break;
    
                default:
                    break;
            }
        }
    }
}
