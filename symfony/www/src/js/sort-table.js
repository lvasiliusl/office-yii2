// start all functions
$(document).ready(function(){
  sortTable("table.js-sortable th:not(.hide-sortable)");
})

// Sort table
function sortTable(elem){
  $(elem).click(function(){
    var desc = changeClass(this);
    sort(this, desc);
  })

  function changeClass(elem){ /*changeClass up/down*/
    var desc;
    var flag = 0;
    if($(elem).attr("class") == "" || $(elem).attr("class") == undefined){
      flag = 0;
    }
    if ($(elem).hasClass("up")){
      flag = 1;
    }
    if($(elem).hasClass("down")){
      flag = 2;
    }
    switch(flag) {
      case 0: 
        $(elem).closest("tr").find("th").removeClass("up").removeClass("down");
        $(elem).addClass("down");
        desc = true;
      break
      case 1:
        $(elem).removeClass("up").addClass("down");
        desc = true;
      break
      case 2:
        $(elem).removeClass("down").addClass("up");
        desc = false;
      break
    }
    return desc;
  }

  function sort(elem, desc){
    var tbody = $(elem).closest("table").find('tbody')[0];
    var colNumber = $(elem).index();
    var rows = [];

    for (var i = tbody.children.length - 1; i >= 0; i--) {
      var child = tbody.removeChild(tbody.children[i]);
      rows.push(child);
    }

    rows.sort(function(a, b) {
      var result = 0;
      var aHtml = $(a).find('td')[colNumber].innerHTML;
      var bHtml = $(b).find('td')[colNumber].innerHTML;
      if (new Date(aHtml) != "Invalid Date"){ /*if date */
        aHtml = new Date (aHtml);
        bHtml = new Date (bHtml);
      }
      if (aHtml > bHtml){
        result = -1;
      }
      if (aHtml < bHtml){
        result = 1;
      }

      return desc ? result : - result;
    })

    for (var i = 0; i < rows.length; i++) {
      tbody.appendChild(rows[i]);
    }
  }
}

window.sortTable = sortTable;