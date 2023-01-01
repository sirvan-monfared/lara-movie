/******/ (() => { // webpackBootstrap
/*!*********************************************!*\
  !*** ./resources/admin/js/remote-select.js ***!
  \*********************************************/
function initRemoteSelect() {
  $("*[data-remote-load-data]").each(function () {
    var $this = $(this);
    $this.select2({
      language: "fa",
      ajax: {
        url: $this.attr('data-remote-url'),
        dataType: 'json',
        delay: 250,
        data: function data(params) {
          return {
            keyword: params.term
          };
        },
        processResults: function processResults(data) {
          return {
            results: data
          };
        },
        cache: true
      },
      escapeMarkup: function escapeMarkup(markup) {
        return markup;
      },
      // let our custom formatter work
      minimumInputLength: 3,
      templateResult: formatRepo,
      templateSelection: formatRepoSelection
    });
  });
}

function formatRepo(repo) {
  if (repo.loading) return repo.text;
  var markup = "<div class='select2-result-repository clearfix'>";

  if (repo.featured_image_thumb) {
    markup += "<div class='select2-result-repository__avatar'><img src='" + repo.featured_image_thumb + "' /></div>";
    markup += "<div class='select2-result-repository__meta'>";
  }

  markup += "<div class='select2-result-repository__title'>" + repo.name + "</div></div>";

  if (repo.description) {
    markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
  }

  if (repo.featured_image_thumb) {
    markup += "</div>"; // closing tag for 'select2-result-repository__meta'
  }

  markup += "<div class='row select2-result-repository__statistics'>";
  markup += "</div>";
  return markup;
}

function formatRepoSelection(repo) {
  return repo.name || repo.text;
}

initRemoteSelect();
/******/ })()
;