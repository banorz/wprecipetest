WPUltimatePostGrid = WPUltimatePostGrid || {};
WPUltimatePostGrid.ajaxUpdateTimer = null;

WPUltimatePostGrid.initFilterText_isotope = function(container) {
    WPUltimatePostGrid.initFilterIsotope(container);
    WPUltimatePostGrid.initFilterText(container);
};

WPUltimatePostGrid.initFilterText_dropdown = function(container) {
    WPUltimatePostGrid.initFilterDropdown(container);
    WPUltimatePostGrid.initFilterText(container);
};

WPUltimatePostGrid.initFilterText = function(container) {
    var grid_id = container.data('grid');
    var input = container.find('.wpupg-filter-text-input');
    var grid = WPUltimatePostGrid.grids[grid_id];

    if(input.val() !== '') {
        WPUltimatePostGrid.ajaxFilterText(grid, input);
    }

    input.on('keyup change', function() {
        clearTimeout(WPUltimatePostGrid.ajaxUpdateTimer);
        var search = input.val();

        // Hide/show combined filter types
        if(search == '') {
            container.find('.wpupg-filter-isotope-term').css('opacity', '1');
            container.find('.select2wpupg-container').css('opacity', '1');
        } else {
            container.find('.wpupg-filter-isotope-term').css('opacity', '0.5');
            container.find('.select2wpupg-container').css('opacity', '0.5');
        }
        
        if(search != grid.filter_text_search) {
            WPUltimatePostGrid.ajaxUpdateTimer = setTimeout(function() {
                if(search == '') {
                    grid.filter_text = false;
                    grid.filter_text_search = '';
                    grid.filter_text_posts = [];
                    WPUltimatePostGrid.filterGrid(grid_id);
                } else {
                    WPUltimatePostGrid.ajaxFilterText(grid, container, search);
                }

                // Load More button as well?
                var load_more_container = container.siblings('#wpupg-grid-' + container.data('grid') + '-pagination.wpupg-pagination-load_more');
                if(load_more_container) {
                    if(search) {
                        load_more_container.find('.wpupg-pagination-button').fadeOut();
                    } else {
                        var all_posts = Object.keys(grid.data.posts.all).map(function (key) {return grid.data.posts.all[key]});
                        if(all_posts.length > grid.posts.length) {
                            load_more_container.find('.wpupg-pagination-button').fadeIn();
                        }
                    }
                }

                // Pages buttons as well?
                var pages_container = container.siblings('#wpupg-grid-' + container.data('grid') + '-pagination.wpupg-pagination-pages');
                if(pages_container) {
                    if(search) {
                        pages_container.fadeOut();
                    } else {
                        pages_container.fadeIn();
                    }
                }
            }, 500);
        }
    });
};

WPUltimatePostGrid.updateFilterText_isotope = function(container, taxonomy, type, search) {
    if(type == 'text') {
        WPUltimatePostGrid.updateFilterText(container, taxonomy, type, search);
    }
    if(type == 'terms') {
        WPUltimatePostGrid.updateFilterIsotope(container, taxonomy, type, search);
    }
};

WPUltimatePostGrid.updateFilterText_dropdown = function(container, taxonomy, type, search) {
    if(type == 'text') {
        WPUltimatePostGrid.updateFilterText(container, taxonomy, type, search);
    }
    if(type == 'terms') {
        WPUltimatePostGrid.updateFilterDropdown(container, taxonomy, type, search);
    }
};

WPUltimatePostGrid.updateFilterText = function(container, taxonomy, type, search) {
    var input = container.find('.wpupg-filter-text-input');
    input.val(search).change();
};

WPUltimatePostGrid.ajaxFilterText = function(grid, container, search) {
    var data = {
        action: 'wpupg_filter_text',
        security: wpupg_public.nonce,
        grid: container.data('grid'),
        search: search
    };

    jQuery.post(wpupg_public.ajax_url, data, function(html) {
        var posts = jQuery(html).toArray();
        
        var posts_to_add = [];
        var posts_to_filter = [];

        for(var i=0; i < posts.length; i++) {
            var post_id = jQuery(posts[i]).data('id');

            if(post_id !== undefined) {
                if(jQuery.inArray(post_id, grid.posts) == -1) {
                    posts_to_add.push(posts[i]);
                }
                posts_to_filter.push(post_id);
            }
        }

        WPUltimatePostGrid.insertPosts(container.data('grid'), posts_to_add);
        grid.filter_text = true;
        grid.filter_text_search = search;
        grid.filter_text_posts = posts_to_filter;
        WPUltimatePostGrid.filterGrid(container.data('grid'));
    });
};