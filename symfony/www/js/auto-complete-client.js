(function($) {
    $(document).ready(function() {

        $('.clients-autocomplete').each(function() {
            var url = $(this).data('source');
            $(this).select2({

                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {

                        return {
                            query: params.term, // search term
                            page: params.page,
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data
                        };
                    },
                    cache: true,
                },
                    escapeMarkup: function (markup) { return markup; },
                    minimumInputLength: 1,
                    templateResult: formatRepo,
                    templateSelection: formatRepoSelection,
            });

            function formatRepo (repo) {
                // console.log('REPO', repo);
                if (repo.loading) {
                    return repo.text;
                }
                var markup = "<div class='select2-result-repository clearfix'>" +
                // "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.name + "</div>";

                if (repo.email) {
                    markup += "<div class='select2-result-repository__description'>" + repo.email + "</div>";
                }

                markup += "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.origin + "</div>" +
                "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.projects_count + " Projects</div>" +
                "</div>" +
                "</div></div>";

                return markup;
            }

            function formatRepoSelection (repo) {
                return repo.id || repo.name;
            }

        });


    });
})(jQuery)
