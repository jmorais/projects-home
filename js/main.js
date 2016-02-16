String.prototype.removeAccents = function() {
  return this.replace(/[áàãâä]/gi,"a")
             .replace(/[éè¨ê]/gi,"e")
             .replace(/[íìïî]/gi,"i")
             .replace(/[óòöôõ]/gi,"o")
             .replace(/[úùüû]/gi, "u")
             .replace(/[ç]/gi, "c")
             .replace(/[ñ]/gi, "n");
};

Array.prototype.chunk = function(size) {
  var R = [];
  for (var i=0,len=this.length; i<len; i+=size)
    R.push(this.slice(i,i+size));
  return R;
}

var all_projects;

$(function(){

  all_projects = $(".project");

  $("#search").keyup(function() {

    $projects = all_projects;
    term = $(this).val().toLowerCase().trim();

    match_projects = []

    if (term != '') {
      $projects.each(function(i, project) {

        if ($(project).text().toLowerCase().removeAccents().indexOf(term) != -1) {
          match_projects.push(project);
        }

      });
    } else {
      match_projects = $projects.toArray();
    }

    $container = $("#projects .container-fluid");
    $container.html('');

    chunks = match_projects.chunk(3);

    $(chunks).each(function(i, row) {
      $row = $("<div class='row'></div>");

      if (row.length == 3) {


        $row.append(
          $("<div class='col-md-4'></div>").append(row[0])
        ).append(
          $("<div class='col-md-4'></div>").append(row[1])
        ).append(
          $("<div class='col-md-4'></div>").append(row[2])
        );


      } else if (row.length == 2) {

        $row.append(
          $("<div class='col-md-4 col-md-offset-2'></div>").append(row[0])
        ).append(
          $("<div class='col-md-4'></div>").append(row[1])
        );


      } else if (row.length == 1) {
        $row.append(
          $("<div class='col-md-4 col-md-offset-4'></div>").append(row[0])
        )
      }

      $container.append($row);

    });

    if (match_projects.length == 0) {
      $empty = $("<div class='empty'><img src='favicon.png'> <span>Nenhum projeto encontrado</span></div>");
      $container.html($empty);
    }

  });

});