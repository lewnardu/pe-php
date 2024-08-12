
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var today = new Date();
    var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    var formattedDate = firstDayOfMonth.toISOString().split('T')[0];
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        locale: 'pt-br',
        initialDate: formattedDate,
        navLinks: true,
        selectable: true,
        selectMirror: true,
        // Comentando o trecho de select
        // select: function(arg) {
        //     console.log(arg);
        //     var title = prompt('Event Title:');
        //     if (title) {
        //         calendar.addEvent({
        //             title: title,
        //             start: arg.start,
        //             end: arg.end,
        //             allDay: arg.allDay
        //         })
        //     }
        //     calendar.unselect()
        // },
        // eventClick: function(arg) {
        //     if (confirm('Are you sure you want to delete this event?')) {
        //         arg.event.remove()
        //     }
        // },
        eventContent: function(arg) {
            let iconClass = '';
            let iconColorClass = '';
            if (arg.event.extendedProps.icon === 'sun') {
                iconClass = 'fas fa-sun';
                iconColorClass = 'icon-sun';
            } else if (arg.event.extendedProps.icon === 'moon') {
                iconClass = 'fas fa-moon';
                iconColorClass = 'icon-moon';
            }
            return {
                html: `<i class="${iconClass} ${iconColorClass}"></i> ${arg.event.title}`
            };
        },
        editable: true,
        dayMaxEvents: true,
        events: [
            {
                title: 'All Day Event',
                start: '2024-08-01T07:00:00',
                end: '2024-08-01T19:00:00',
                allDay: true,
                backgroundColor: 'rgba(0, 123, 255, 0.3)',  
                borderColor: 'rgba(0, 123, 255, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'sun'
                }
            },
            {
                title: 'Long Event',
                start: '2024-08-02T19:00:00',
                end: '2024-08-03T07:00:00',
                allDay: true,
                backgroundColor: 'rgba(52, 58, 64, 0.3)',  
                borderColor: 'rgba(0, 123, 255, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'sun'
                }
            },
            {
                groupId: 999,
                title: 'Repeating Event',
                start: '2024-08-05T07:00:00',
                end: '2024-08-05T19:00:00',
                allDay: true,
                backgroundColor: 'rgba(0, 123, 255, 0.3)',  
                borderColor: 'rgba(0, 123, 255, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'sun'
                }
            },
            {
                groupId: 999,
                title: 'Repeating Event',
                start: '2024-08-06T19:00:00',
                end: '2024-08-07T07:00:00',
                allDay: true,
                backgroundColor: 'rgba(52, 58, 64, 0.3)',  
                borderColor: 'rgba(52, 58, 64, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'moon'
                }
            },
            {
                title: 'Conference',
                start: '2024-08-08T07:00:00',
                end: '2024-08-08T19:00:00',
                allDay: true,
                backgroundColor: 'rgba(0, 123, 255, 0.3)',  
                borderColor: 'rgba(0, 123, 255, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'sun'
                }
            },
            {
                title: 'Meeting',
                start: '2024-08-09T07:00:00',
                end: '2024-08-09T19:00:00',
                allDay: true,
                backgroundColor: 'rgba(0, 123, 255, 0.3)',  
                borderColor: 'rgba(0, 123, 255, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'sun'
                }
            },
            {
                title: 'Lunch',
                start: '2024-08-10T07:00:00',
                end: '2024-08-10T19:00:00',
                allDay: true,
                backgroundColor: 'rgba(0, 123, 255, 0.3)',  
                borderColor: 'rgba(0, 123, 255, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'sun'
                }
            },
            {
                title: 'Meeting',
                start: '2024-08-11T07:00:00',
                end: '2024-08-11T19:00:00',
                allDay: true,
                backgroundColor: 'rgba(0, 123, 255, 0.3)',  
                borderColor: 'rgba(0, 123, 255, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'sun'
                }
            },
            {
                title: 'Happy Hour',
                start: '2024-08-12T19:00:00',
                end: '2024-08-13T07:00:00',
                allDay: true,
                backgroundColor: 'rgba(52, 58, 64, 0.3)',  
                borderColor: 'rgba(52, 58, 64, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'moon'
                }
            },
            {
                title: 'Dinner',
                start: '2024-08-13T19:00:00',
                end: '2024-08-14T07:00:00',
                allDay: true,
                backgroundColor: 'rgba(52, 58, 64, 0.3)',  
                borderColor: 'rgba(52, 58, 64, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'moon'
                }
            },
            {
                title: 'Birthday Party',
                start: '2024-08-14T07:00:00',
                end: '2024-08-14T19:00:00',
                allDay: true,
                backgroundColor: 'rgba(0, 123, 255, 0.3)',  
                borderColor: 'rgba(0, 123, 255, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'sun'
                }
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2024-08-15T07:00:00',
                end: '2024-08-15T19:00:00',
                allDay: true,
                backgroundColor: 'rgba(0, 123, 255, 0.3)',  
                borderColor: 'rgba(0, 123, 255, 0.3)',      
                textColor: '#000',
                extendedProps: {
                    icon: 'sun'
                }
            }
        ]        
    });

    calendar.render();
});