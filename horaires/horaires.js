var Calendar = tui.Calendar;
var calendar = new Calendar('#calendar', {
    usageStatistics:false,
    isReadOnly:false,
    defaultView: 'month',
    scheduleView:true,
    month: {
        daynames: ["Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"]
    },
    calendars: [
        {
          id: '1',
          name: 'Test',
          color: '#d93a32',
          bgColor: '#9e5fff',
          dragBgColor: '#9e5fff',
          borderColor: '#9e5fff'
        }
      ],
    useCreationPopup : true,
    useDetailPopup : true
});

calendar.createSchedules([
  {
      id: '1',
      calendarId: '1',
      title: 'Test Event',
      category: 'time',
      dueDateClass: '',
      start: '2021-07-28T10:30:00+05:00',
      end: '2021-07-28T13:30:00+05:00'
  }
]);

  