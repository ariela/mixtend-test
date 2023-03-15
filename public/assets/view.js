document.addEventListener("DOMContentLoaded", function () {
  $.ajax({
    type:     "GET",
    url:      "/api/current.php",
    dataType: "json",
    async:    false,
  }).then(
    function (json) {
      // 開始日を取得
      var startDay = json.start;

      // カレンダー構築
      var calendarEl = document.getElementById("calendar");
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialDate: startDay, // AJAXで取得した開始日を設定
        headerToolbar: null,
        locale: "ja",
        initialView: "timeGridFourDay",
        views: {
          timeGridFourDay: {
            type: "timeGrid",
            duration: { days: 3 },
            allDaySlot: false,
            slotLabelFormat: [
              {
                hour: "numeric",
                minute: "2-digit",
                omitZeroMinute: false,
                meridiem: "short",
              },
            ],
          },
        },
        displayEventTime: false,
        eventSources: [
          // イベントデータを取得
          {
            url: "/api/event.php",
            method: "GET",
            failure: function () {
              alert("there was an error while fetching events!");
            },
            color: "#48B5A9", // a non-ajax option
            textColor: "white", // a non-ajax option
          },
        ],
      });
      calendar.render();
    },
    function () {
      // jsonの読み込みに失敗
      console.log("読み込みに失敗しました");
    }
  );
});
