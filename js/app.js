(function ($, root, undefined) {

    $(function () {

        'use strict';




        var $date_of_birth = $('#date_of_birth');
        if ($date_of_birth.prop('type') != 'date') {
            $date_of_birth.datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                minDate: '-100Y',
                maxDate: 0,
            });
        }



        $('.frontpage_slider').bxSlider({
            'pager': false,
            'controls': true,
            'auto': true,
            'speed': 1300,
            'pause': 8000

        });


        $('.news_slider').bxSlider({
            'pager': true,
            'controls': true,
            'minSlides': 2,
            'maxSlides': 2,
            'moveSlides': 1,
        });


        $('.prevent_pasting').bind('copy paste', function (e) {
            e.preventDefault();
        });


        $('.teacher-toggle').click(function (event) {
            event.preventDefault();
            var $teacherRow = $(this).closest('.teachers-row');

            // Place form inside the html of the toggled teacher
            $('#frm_form_8_container').appendTo($teacherRow.find('.form-container'));
            $('#field_professorname').val($teacherRow.find('.teacher-email').text().trim());
            $teacherRow.toggleClass('toggled').find('.contact-teacher').slideToggle();
        });

        $('#prenav-toggle').click(function (event) {
            // console.log('asdf');
            event.preventDefault();
            $(this).toggleClass('toggled');
            $('.navbar-pre').slideToggle();
        });

        $('.toggle-categories').click(function (event) {
            event.preventDefault();
            $('.program-categories').toggleClass('translated');
        })




        // $('.program-inner').matchHeight({
        //      byRow: true
        // });
        // $('.program-children').matchHeight({
        //      byRow: true
        // });



        function filterTeachers() {
            $('.teachers-filter a').click(function (event) {
                event.preventDefault();
                event.stopPropagation();
                // Store value
                var $value = jQuery(this).html().trim();
                // Hide other rows
                $('.visible').removeClass('visible');
                $('.char-' + $value).addClass('visible');
            })
        }

        filterTeachers();

        // First item on the teachers filter click
        $('.teachers-filter ul li:first-of-type a').click();

        var $class = $('.frm_message');
        if (typeof submittedEmail !== 'undefined') {
            // Palidhje
            var $submittedRow = $('.teachers-row:contains(' + submittedEmail.trim() + ')');
            $('#frm_form_8_container').appendTo($submittedRow.find('.form-container'));
            var teacherChar = $submittedRow.attr('class').split('char-')[1].charAt(0);

            $('.visible').removeClass('visible');
            $('.char-' + teacherChar).addClass('visible ');
            $submittedRow.addClass('toggled submitted-row');
            $submittedRow.find('.contact-teacher').slideDown();
        }







        // INSCRIPTION FOR EVENTS BOOKING
        // INSCRIPTION FOR EVENTS BOOKING
        var $no_people = $('#no_people');
        var $extra_people_fields = $('.extra_people_field');
        $extra_people_fields.hide();
        var $people_val = $no_people.val();
        $('.booking_people_' + $people_val).show();

        $no_people.on('change', function (e) {
            var $this = $(this);
            var $people_val = $this.val();
            $extra_people_fields.hide();
            $('.booking_people_' + $people_val).show();
        });
        // INSCRIPTION FOR EVENTS BOOKING
        // INSCRIPTION FOR EVENTS BOOKING




        if (typeof google != 'undefined') {
            // locations map
            // locations map
            var map_theme = [{ featureType: "all", elementType: "all", stylers: [{ visibility: "off" }] }, { featureType: "administrative", elementType: "all", stylers: [{ visibility: "on" }] }, { featureType: "landscape", elementType: "all", stylers: [{ visibility: "on" }] }, { featureType: "poi", elementType: "all", stylers: [{ visibility: "on" }] }, { featureType: "road", elementType: "all", stylers: [{ visibility: "on" }] }, { featureType: "transit", elementType: "all", stylers: [{ visibility: "on" }] }, { featureType: "water", elementType: "all", stylers: [{ visibility: "on" }] }, { featureType: "all", elementType: "geometry.fill", stylers: [{ weight: "2.00" }] }, { featureType: "all", elementType: "geometry.stroke", stylers: [{ color: "#9c9c9c" }] }, { featureType: "all", elementType: "labels.text", stylers: [{ visibility: "on" }] }, { featureType: "landscape", elementType: "all", stylers: [{ color: "#f2f2f2" }] }, { featureType: "landscape", elementType: "geometry.fill", stylers: [{ color: "#ffffff" }] }, { featureType: "landscape.man_made", elementType: "geometry.fill", stylers: [{ color: "#ffffff" }] }, { featureType: "poi", elementType: "all", stylers: [{ visibility: "off" }] }, { featureType: "road", elementType: "all", stylers: [{ saturation: -100 }, { lightness: 45 }] }, { featureType: "road", elementType: "geometry.fill", stylers: [{ color: "#eeeeee" }] }, { featureType: "road", elementType: "labels.text.fill", stylers: [{ color: "#7b7b7b" }] }, { featureType: "road", elementType: "labels.text.stroke", stylers: [{ color: "#ffffff" }] }, { featureType: "road.highway", elementType: "all", stylers: [{ visibility: "simplified" }] }, { featureType: "road.arterial", elementType: "labels.icon", stylers: [{ visibility: "off" }] }, { featureType: "transit", elementType: "all", stylers: [{ visibility: "off" }] }, { featureType: "water", elementType: "all", stylers: [{ color: "#46bcec" }, { visibility: "on" }] }, { featureType: "water", elementType: "geometry.fill", stylers: [{ color: "#c8d7d4" }] }, { featureType: "water", elementType: "labels.text.fill", stylers: [{ color: "#070707" }] }, { featureType: "water", elementType: "labels.text.stroke", stylers: [{ color: "#ffffff" }] }];




            var map_options = {
                zoom: 13,
                mapTypeControl: true,
                scrollwheel: false,
                draggable: true,
                navigationControlOptions: { style: google.maps.NavigationControlStyle.SMALL },
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: map_theme
            };



            if (typeof locations_for_map != 'undefined') {



                var location_map_container = $('#footer-pins');
                location_map_container.css({
                    width: '100%'
                })

                var location_map = new google.maps.Map(location_map_container.get(0), map_options);
                var location_bounds = new google.maps.LatLngBounds();
                var location_infowindow = new google.maps.InfoWindow({ content: '...' });
                var location_markers = [];

                for (var i = 0; i < locations_for_map.length; i++) {
                    var location_for_map = locations_for_map[i];
                    if (location_for_map != null) {
                        addPointToMap(location_map, location_for_map, location_bounds, location_infowindow, location_markers, true);
                    }

                }
                location_map.initialZoom = true;
                location_map.fitBounds(location_bounds);




            }

            // locations map
            // locations map


            if (typeof single_location_for_map !== 'undefined') {

                if (single_location_for_map.default_style) {
                    map_options.styles = null;
                }


                var single_map_container = $('#single_location_map');
                single_map_container.css({
                    width: '100%'
                })
                var single_map = new google.maps.Map(single_map_container.get(0), map_options);
                var single_location_bounds = new google.maps.LatLngBounds();
                var single_location_infowindow = new google.maps.InfoWindow({ content: '...' });
                var single_location_markers = [];
                addPointToMap(single_map, single_location_for_map, single_location_bounds, single_location_infowindow, single_location_markers, false);
                single_map.setCenter(single_location_markers[0].position);
                single_map.setZoom(16);

            }

        };  // end of google defined


        function addPointToMap(map, location, bounds, infowindow, markers, custom_icon) {
            var latitude = location.lat;
            var longitude = location.lng;

            var customMarker = null;
            if (custom_icon) {
                customMarker = {
                    url: theme_directory + '/assets/marker.svg',
                    size: new google.maps.Size(30, 45),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(5, 22)
                };
            }





            var latlng = new google.maps.LatLng(latitude, longitude);
            var marker = new google.maps.Marker({
                map: map,
                position: latlng,
                title: location.title,
                id: location.id,
                icon: customMarker
            });

            marker.addListener('click', function () {
                if (this.id > 0) {
                    infowindow.setContent('<span style="color:black">' + this.title + '<br><a style="color:red" href="?p=' + this.id + '">Afficher</a></span>');
                    infowindow.open(map, this);
                }
            });


            markers.push(marker);

            bounds.extend(latlng);


        };





        // COURSE SEARCH
        // COURSE SEARCH



        $('.locations_dropdown').on('change', function (e) {
            var $this = $(this);
            var $val = $this.val();
            window.location = $val;
        });



        // if press escape key, hide menu
        $(document).on('keydown', function (e) {
            if (e.keyCode == 27) {
                $('.search_box').removeClass('visible');
            }
        })

        $('.search_box').on('click', function (e) {
            e.stopPropagation();
        });

        $('.search_button').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            var $this = $(this);
            var $box = $($this.data('box'));

            if ($box.hasClass('visible')) {
                $('.search_box').removeClass('visible');
            } else {
                $('.search_box').removeClass('visible');
                $box.addClass('visible');

            }

        })

        var $search_checks = $('.search_check');
        var $cours_search = $('#cours_search');
        var $courses_container = $('#courses_container');
        var $course_size = $('#course_size');
        var $courses_template = $('#courses_template').html();
        var $reset_course_form = $('#reset_course_form');

        var $age_summary = $('#age_summary');
        var $cat_summary = $('#cat_summary');
        var $location_summary = $('#location_summary');

        var $lower_age = 0;
        var $upper_age = 100;

        // change SEARCH based on GET PARAM
        var wls = window.location.search;
        if (wls) {
            if (wls.indexOf('k=') !== -1) {
                var s = wls.split('k=')[1];
                var s = s.split('&')[0];
                var ssub = s.replace(/\+/g, ' ');
                ssub = decodeURIComponent(ssub);
                $cours_search.val(ssub).click();
            }

            if (wls.indexOf('category=') !== -1) {
                var c = wls.split('category=')[1];
                var c = c.split('&')[0];
                var csub = c.replace(/\+/g, ' ');
                csub = decodeURIComponent(csub);
                $search_checks.each(function () {
                    var $this = $(this);
                    if ($this.data('field') == 'category' && $this.val() == csub) {
                        this.click();
                    }
                })
            }
            if (wls.indexOf('age=') !== -1) {
                var a = wls.split('age=')[1];
                var a = a.split('&')[0];
                var asub = a.replace(/\+/g, ' ');
                asub = decodeURIComponent(asub);
                $search_checks.each(function () {
                    var $this = $(this);
                    if ($this.data('field') == 'age' && $this.val() == asub) {
                        this.click();
                    }
                })
            }
            if (wls.indexOf('loc=') !== -1) {
                var l = wls.split('loc=')[1];
                var l = l.split('&')[0];
                var lsub = l.replace(/\+/g, ' ');
                lsub = decodeURIComponent(lsub);
                $search_checks.each(function () {
                    var $this = $(this);
                    if ($this.data('field') == 'location' && $this.val() == lsub) {
                        this.click();
                    }
                })
            }

            // if ( wls.indexOf('age=') !== -1) {
            //     var ages = wls.split('age=')[1];
            //     var ages =  ages.split('&')[0];
            //     var agesub = ages.replace(/\+/g, ' ');
            //     var agesub = decodeURIComponent(agesub);
            //     var agesplit = agesub.split('-');
            //     $lower_age  = agesplit[0];
            //     $upper_age  = agesplit[1];
            // }




        };

        if (typeof course_category != 'undefined') {
            setTimeout(function () {
                $search_checks.each(function () {
                    var $this = $(this);
                    if ($this.data('field') == 'category' && $this.val() == course_category) {
                        this.click();
                    }
                })

            }, 300);

        }


        $('.search_check').on('click', function (e) {
            displayCourses(null, null, null);
        });



        if (typeof search_url != 'undefined') {


            $.ajax({
                url: search_url
            }).done(function (data) {



                // ORIGINAL SET OF COURSES
                var courses = processCourses(data);
                var compiled = _.template($courses_template);

                displayCourses(courses, $courses_container, compiled)



                $reset_course_form.on('click', function () {
                    $('.search_check').attr('checked', false);
                    $('#cours_search').val('');
                    $reset_course_form.hide();
                    displayCourses(courses, $courses_container, compiled)
                });



                $search_checks.on('change', function () {
                    displayCourses(courses, $courses_container, compiled)
                });


                $cours_search.on('keyup', function () {
                    displayCourses(courses, $courses_container, compiled)
                });




            });

        }


        function displayCourses(courses, courses_container, compiled) {

            $('.search_box').removeClass('visible');

            var $search_val = $cours_search.val().toLowerCase();
            var $location = new Array();
            var $cat = new Array();
            var $ages = new Array();

            var $locations_summary = new Array();
            var $cats_summary = new Array();
            var $ages_summary = new Array();

            $search_checks.each(function () {
                var $this = $(this);
                var $check_type = $this.data('field');
                if ($this.is(":checked")) {

                    if ($check_type == 'location') {
                        $location.push(parseInt($this.val()));
                        $locations_summary.push($this.data('label'))
                    } else if ($check_type == 'age') {


                        if (typeof use_new_age_range !== "undefined") {
                            $ages.push($this.val());
                        } else {
                            $ages.push(parseInt($this.val()));
                        }



                        $ages_summary.push($this.data('label'))
                    } else if ($check_type == 'category') {
                        $cat.push(parseInt($this.val()));
                        $cats_summary.push($this.data('label'))
                    }
                };

                if ($ages_summary.length > 0) {
                    $age_summary.html($ages_summary.join(' '));
                } else {
                    $age_summary.html($age_summary.data('default'));
                }
                if ($cats_summary.length > 0) {
                    $cat_summary.html($cats_summary.join(' '));
                } else {
                    $cat_summary.html($cat_summary.data('default'));
                }
                if ($locations_summary.length > 0) {
                    $location_summary.html($locations_summary.join(' '));
                } else {
                    $location_summary.html($location_summary.data('default'));
                }


            });

            $location = _.filter($location, function (num) { return num > 0; });
            $cat = _.filter($cat, function (num) { return num > 0; });

            if ($search_val != '' || $location.length > 0 || $cat.length > 0 || $ages.length > 0) {
                $reset_course_form.show();
            } else {
                $reset_course_form.hide();
            }



            var s_courses = processCourses(courses, $search_val, $cat, $location, $ages);


            if (s_courses.length == 0) {
                $course_size.html('<p>Aucun cours trouvé </p>');
            } else {
                $course_size.html(''); //  s_courses.length + ' courses found'
            }

            if (courses_container) { // required for homepage not having courses_container
                courses_container.html(compiled({ courses: s_courses }));
            }



            $('#back_to_top').on('click', function (e) {
                e.preventDefault();
                $("html, body").animate({ scrollTop: 0 }, 500);
            })




        }


        function processCourses(courses, search, category, location, ages) {



            // DONT SHOW COURSE PARENTS FOR MUSIC
            // ALSO DONT SHOW COURSES THAT HAVE A TICKBOX TICKED hide_in_search
            // SHOW COUSE 5656 always
            var courses = _.reject(courses, function (c) {
                return (
                    (c.slug == 'music' && c.post_parent == 0 && c.id != 5656) ||
                    (c.hide_in_search == true)
                );
            });


            if (search && search != '') {
                var search_array = _.reject(removeDiacritics(search.toLowerCase()).split(' '), function (t) { return t == '' });
                var courses = _.filter(courses, function (c) {
                    return (
                        _.every(search_array, function (t) { return c.searchfield.indexOf(t) > -1 })
                    );
                });
            }


            if (category && category != '') {
                var courses = _.reject(courses, function (c) {
                    //	return c.categories[0].term_id !=  category
                    return !_.contains(category, c.categories[0].term_id);
                });
            }

            if (location && location != '') {
                var courses = _.reject(courses, function (c) {
                    // return c.zone !=  location
                    //return !_.contains(  c.zone  , location)
                    return (_.intersection(location, c.zone).length == 0);
                });
            }


            if (typeof use_new_age_range !== "undefined") {
                if (ages && ages.length > 0) {
                    console.log(ages);
                    var courses = _.reject(courses, function (c) {
                        if (c.age_ranges.length > 0) {
                            return (_.intersection(ages, c.age_ranges).length == 0);
                        } else {
                            return true;
                        }

                    });
                }

            } else { // if use old range system

                if (ages && ages.length > 0) {
                    var min_age = 100;
                    var max_age = 0;
                    _.each(ages, function (age, index, list) {
                        if (age == 4) {
                            var mn = 4;
                            var mx = 7;
                        } else if (age == 7) {
                            var mn = 7;
                            var mx = 25;
                        } else if (age == 25) {
                            var mn = 25;
                            var mx = 70;
                        }
                        if (mn < min_age) {
                            min_age = mn;
                        };
                        if (mx > max_age) {
                            max_age = mx;
                        }
                    });




                    var courses = _.filter(courses, function (c) {
                        return ((c.lower_age > min_age || c.upper_age > min_age) && ((c.lower_age < max_age || c.upper_age <= max_age)))
                    });

                }

            } // if use old range system









            var courses = _.toArray(courses);//  CONVERT  OBJECT TO ARRAY


            // PROCESS ARRAY
            for (var i = 0; i < courses.length; i++) {
                var course = courses[i];



                if (course.categories.length > 0) {
                    course['slug'] = course.categories[0].slug;
                }


                // ADD NEW UL.ROW EVERY 3 POSTS FOR LAYOUT
                course['new_row'] = (i % 3 == 2) ? '</div><div class=" row">' : '';




            }


            return courses;


        };

        // COURSE SEARCH
        // COURSE SEARCH



        // INSCRIPTION FORM
        // INSCRIPTION FORM

        if (typeof search_url != 'undefined') {
            var $course_pickers = $('.course_picker');


            $course_pickers.on('change', function () {

                var $this = $(this);
                var $field = $this.data('field');
                // console.log($field, $this.val());
                updateLocationAndOptionsForCourse($field, $this.val());


            });

            ///  auto fill course field if courseid get param is set
            var wls = window.location.search;
            if (wls) {
                if (wls.indexOf('course_id=') !== -1) {
                    var courseid = wls.split('course_id=')[1];
                    var courseid = courseid.split('&')[0];
                    var courseidsub = courseid.replace(/\+/g, ' ');
                    $course_pickers.val(courseidsub).change();
                }
            }




        }

        // INSCRIPTION FORM
        // INSCRIPTION FORM






        function updateLocationAndOptionsForCourse($field, $course_id) {
            var $loc_container = $('#' + $field + 's_container');
            var $loc_template = $('#' + $field + 's_template').html();

            var $options_container = $('#courseoption_container');
            var $options_template = $('#courseoption_template').html();
            var $options_field = $('#options_field');

            $.ajax({
                url: search_url + '?course_id=' + $course_id,
                type: 'get',
                dataType: 'json',
                beforeSend: function () {
                    // $teacher_id_cont.html('');
                },
                success: function (data) {

                    if (data.options) {
                        if (data.options.length > 0) {
                            var optcompiled = _.template($options_template);
                            $options_container.html(optcompiled({ options: data.options }));
                            $options_field.show();
                        } else {
                            $options_field.hide();
                        }
                    } else {
                        $options_field.hide();
                    }

                    if (data.locations.length > 0) {
                        var loccompiled = _.template($loc_template);
                        var locations = _.sortBy(data.locations, 'post_title');
                        $loc_container.html(loccompiled({ locations: locations }));

                    } else {
                        $loc_container.html('');
                    }
                }
            })
        }



    });

})(jQuery, this);





function removeDiacritics(str) {

    var defaultDiacriticsRemovalMap = [
        { 'base': 'A', 'letters': /[\u0041\u24B6\uFF21\u00C0\u00C1\u00C2\u1EA6\u1EA4\u1EAA\u1EA8\u00C3\u0100\u0102\u1EB0\u1EAE\u1EB4\u1EB2\u0226\u01E0\u00C4\u01DE\u1EA2\u00C5\u01FA\u01CD\u0200\u0202\u1EA0\u1EAC\u1EB6\u1E00\u0104\u023A\u2C6F]/g },
        { 'base': 'AA', 'letters': /[\uA732]/g },
        { 'base': 'AE', 'letters': /[\u00C6\u01FC\u01E2]/g },
        { 'base': 'AO', 'letters': /[\uA734]/g },
        { 'base': 'AU', 'letters': /[\uA736]/g },
        { 'base': 'AV', 'letters': /[\uA738\uA73A]/g },
        { 'base': 'AY', 'letters': /[\uA73C]/g },
        { 'base': 'B', 'letters': /[\u0042\u24B7\uFF22\u1E02\u1E04\u1E06\u0243\u0182\u0181]/g },
        { 'base': 'C', 'letters': /[\u0043\u24B8\uFF23\u0106\u0108\u010A\u010C\u00C7\u1E08\u0187\u023B\uA73E]/g },
        { 'base': 'D', 'letters': /[\u0044\u24B9\uFF24\u1E0A\u010E\u1E0C\u1E10\u1E12\u1E0E\u0110\u018B\u018A\u0189\uA779]/g },
        { 'base': 'DZ', 'letters': /[\u01F1\u01C4]/g },
        { 'base': 'Dz', 'letters': /[\u01F2\u01C5]/g },
        { 'base': 'E', 'letters': /[\u0045\u24BA\uFF25\u00C8\u00C9\u00CA\u1EC0\u1EBE\u1EC4\u1EC2\u1EBC\u0112\u1E14\u1E16\u0114\u0116\u00CB\u1EBA\u011A\u0204\u0206\u1EB8\u1EC6\u0228\u1E1C\u0118\u1E18\u1E1A\u0190\u018E]/g },
        { 'base': 'F', 'letters': /[\u0046\u24BB\uFF26\u1E1E\u0191\uA77B]/g },
        { 'base': 'G', 'letters': /[\u0047\u24BC\uFF27\u01F4\u011C\u1E20\u011E\u0120\u01E6\u0122\u01E4\u0193\uA7A0\uA77D\uA77E]/g },
        { 'base': 'H', 'letters': /[\u0048\u24BD\uFF28\u0124\u1E22\u1E26\u021E\u1E24\u1E28\u1E2A\u0126\u2C67\u2C75\uA78D]/g },
        { 'base': 'I', 'letters': /[\u0049\u24BE\uFF29\u00CC\u00CD\u00CE\u0128\u012A\u012C\u0130\u00CF\u1E2E\u1EC8\u01CF\u0208\u020A\u1ECA\u012E\u1E2C\u0197]/g },
        { 'base': 'J', 'letters': /[\u004A\u24BF\uFF2A\u0134\u0248]/g },
        { 'base': 'K', 'letters': /[\u004B\u24C0\uFF2B\u1E30\u01E8\u1E32\u0136\u1E34\u0198\u2C69\uA740\uA742\uA744\uA7A2]/g },
        { 'base': 'L', 'letters': /[\u004C\u24C1\uFF2C\u013F\u0139\u013D\u1E36\u1E38\u013B\u1E3C\u1E3A\u0141\u023D\u2C62\u2C60\uA748\uA746\uA780]/g },
        { 'base': 'LJ', 'letters': /[\u01C7]/g },
        { 'base': 'Lj', 'letters': /[\u01C8]/g },
        { 'base': 'M', 'letters': /[\u004D\u24C2\uFF2D\u1E3E\u1E40\u1E42\u2C6E\u019C]/g },
        { 'base': 'N', 'letters': /[\u004E\u24C3\uFF2E\u01F8\u0143\u00D1\u1E44\u0147\u1E46\u0145\u1E4A\u1E48\u0220\u019D\uA790\uA7A4]/g },
        { 'base': 'NJ', 'letters': /[\u01CA]/g },
        { 'base': 'Nj', 'letters': /[\u01CB]/g },
        { 'base': 'O', 'letters': /[\u004F\u24C4\uFF2F\u00D2\u00D3\u00D4\u1ED2\u1ED0\u1ED6\u1ED4\u00D5\u1E4C\u022C\u1E4E\u014C\u1E50\u1E52\u014E\u022E\u0230\u00D6\u022A\u1ECE\u0150\u01D1\u020C\u020E\u01A0\u1EDC\u1EDA\u1EE0\u1EDE\u1EE2\u1ECC\u1ED8\u01EA\u01EC\u00D8\u01FE\u0186\u019F\uA74A\uA74C]/g },
        { 'base': 'OI', 'letters': /[\u01A2]/g },
        { 'base': 'OO', 'letters': /[\uA74E]/g },
        { 'base': 'OU', 'letters': /[\u0222]/g },
        { 'base': 'P', 'letters': /[\u0050\u24C5\uFF30\u1E54\u1E56\u01A4\u2C63\uA750\uA752\uA754]/g },
        { 'base': 'Q', 'letters': /[\u0051\u24C6\uFF31\uA756\uA758\u024A]/g },
        { 'base': 'R', 'letters': /[\u0052\u24C7\uFF32\u0154\u1E58\u0158\u0210\u0212\u1E5A\u1E5C\u0156\u1E5E\u024C\u2C64\uA75A\uA7A6\uA782]/g },
        { 'base': 'S', 'letters': /[\u0053\u24C8\uFF33\u1E9E\u015A\u1E64\u015C\u1E60\u0160\u1E66\u1E62\u1E68\u0218\u015E\u2C7E\uA7A8\uA784]/g },
        { 'base': 'T', 'letters': /[\u0054\u24C9\uFF34\u1E6A\u0164\u1E6C\u021A\u0162\u1E70\u1E6E\u0166\u01AC\u01AE\u023E\uA786]/g },
        { 'base': 'TZ', 'letters': /[\uA728]/g },
        { 'base': 'U', 'letters': /[\u0055\u24CA\uFF35\u00D9\u00DA\u00DB\u0168\u1E78\u016A\u1E7A\u016C\u00DC\u01DB\u01D7\u01D5\u01D9\u1EE6\u016E\u0170\u01D3\u0214\u0216\u01AF\u1EEA\u1EE8\u1EEE\u1EEC\u1EF0\u1EE4\u1E72\u0172\u1E76\u1E74\u0244]/g },
        { 'base': 'V', 'letters': /[\u0056\u24CB\uFF36\u1E7C\u1E7E\u01B2\uA75E\u0245]/g },
        { 'base': 'VY', 'letters': /[\uA760]/g },
        { 'base': 'W', 'letters': /[\u0057\u24CC\uFF37\u1E80\u1E82\u0174\u1E86\u1E84\u1E88\u2C72]/g },
        { 'base': 'X', 'letters': /[\u0058\u24CD\uFF38\u1E8A\u1E8C]/g },
        { 'base': 'Y', 'letters': /[\u0059\u24CE\uFF39\u1EF2\u00DD\u0176\u1EF8\u0232\u1E8E\u0178\u1EF6\u1EF4\u01B3\u024E\u1EFE]/g },
        { 'base': 'Z', 'letters': /[\u005A\u24CF\uFF3A\u0179\u1E90\u017B\u017D\u1E92\u1E94\u01B5\u0224\u2C7F\u2C6B\uA762]/g },
        { 'base': 'a', 'letters': /[\u0061\u24D0\uFF41\u1E9A\u00E0\u00E1\u00E2\u1EA7\u1EA5\u1EAB\u1EA9\u00E3\u0101\u0103\u1EB1\u1EAF\u1EB5\u1EB3\u0227\u01E1\u00E4\u01DF\u1EA3\u00E5\u01FB\u01CE\u0201\u0203\u1EA1\u1EAD\u1EB7\u1E01\u0105\u2C65\u0250]/g },
        { 'base': 'aa', 'letters': /[\uA733]/g },
        { 'base': 'ae', 'letters': /[\u00E6\u01FD\u01E3]/g },
        { 'base': 'ao', 'letters': /[\uA735]/g },
        { 'base': 'au', 'letters': /[\uA737]/g },
        { 'base': 'av', 'letters': /[\uA739\uA73B]/g },
        { 'base': 'ay', 'letters': /[\uA73D]/g },
        { 'base': 'b', 'letters': /[\u0062\u24D1\uFF42\u1E03\u1E05\u1E07\u0180\u0183\u0253]/g },
        { 'base': 'c', 'letters': /[\u0063\u24D2\uFF43\u0107\u0109\u010B\u010D\u00E7\u1E09\u0188\u023C\uA73F\u2184]/g },
        { 'base': 'd', 'letters': /[\u0064\u24D3\uFF44\u1E0B\u010F\u1E0D\u1E11\u1E13\u1E0F\u0111\u018C\u0256\u0257\uA77A]/g },
        { 'base': 'dz', 'letters': /[\u01F3\u01C6]/g },
        { 'base': 'e', 'letters': /[\u0065\u24D4\uFF45\u00E8\u00E9\u00EA\u1EC1\u1EBF\u1EC5\u1EC3\u1EBD\u0113\u1E15\u1E17\u0115\u0117\u00EB\u1EBB\u011B\u0205\u0207\u1EB9\u1EC7\u0229\u1E1D\u0119\u1E19\u1E1B\u0247\u025B\u01DD]/g },
        { 'base': 'f', 'letters': /[\u0066\u24D5\uFF46\u1E1F\u0192\uA77C]/g },
        { 'base': 'g', 'letters': /[\u0067\u24D6\uFF47\u01F5\u011D\u1E21\u011F\u0121\u01E7\u0123\u01E5\u0260\uA7A1\u1D79\uA77F]/g },
        { 'base': 'h', 'letters': /[\u0068\u24D7\uFF48\u0125\u1E23\u1E27\u021F\u1E25\u1E29\u1E2B\u1E96\u0127\u2C68\u2C76\u0265]/g },
        { 'base': 'hv', 'letters': /[\u0195]/g },
        { 'base': 'i', 'letters': /[\u0069\u24D8\uFF49\u00EC\u00ED\u00EE\u0129\u012B\u012D\u00EF\u1E2F\u1EC9\u01D0\u0209\u020B\u1ECB\u012F\u1E2D\u0268\u0131]/g },
        { 'base': 'j', 'letters': /[\u006A\u24D9\uFF4A\u0135\u01F0\u0249]/g },
        { 'base': 'k', 'letters': /[\u006B\u24DA\uFF4B\u1E31\u01E9\u1E33\u0137\u1E35\u0199\u2C6A\uA741\uA743\uA745\uA7A3]/g },
        { 'base': 'l', 'letters': /[\u006C\u24DB\uFF4C\u0140\u013A\u013E\u1E37\u1E39\u013C\u1E3D\u1E3B\u017F\u0142\u019A\u026B\u2C61\uA749\uA781\uA747]/g },
        { 'base': 'lj', 'letters': /[\u01C9]/g },
        { 'base': 'm', 'letters': /[\u006D\u24DC\uFF4D\u1E3F\u1E41\u1E43\u0271\u026F]/g },
        { 'base': 'n', 'letters': /[\u006E\u24DD\uFF4E\u01F9\u0144\u00F1\u1E45\u0148\u1E47\u0146\u1E4B\u1E49\u019E\u0272\u0149\uA791\uA7A5]/g },
        { 'base': 'nj', 'letters': /[\u01CC]/g },
        { 'base': 'o', 'letters': /[\u006F\u24DE\uFF4F\u00F2\u00F3\u00F4\u1ED3\u1ED1\u1ED7\u1ED5\u00F5\u1E4D\u022D\u1E4F\u014D\u1E51\u1E53\u014F\u022F\u0231\u00F6\u022B\u1ECF\u0151\u01D2\u020D\u020F\u01A1\u1EDD\u1EDB\u1EE1\u1EDF\u1EE3\u1ECD\u1ED9\u01EB\u01ED\u00F8\u01FF\u0254\uA74B\uA74D\u0275]/g },
        { 'base': 'oi', 'letters': /[\u01A3]/g },
        { 'base': 'oe', 'letters': /[\u0153]/g },
        { 'base': 'ou', 'letters': /[\u0223]/g },
        { 'base': 'oo', 'letters': /[\uA74F]/g },
        { 'base': 'p', 'letters': /[\u0070\u24DF\uFF50\u1E55\u1E57\u01A5\u1D7D\uA751\uA753\uA755]/g },
        { 'base': 'q', 'letters': /[\u0071\u24E0\uFF51\u024B\uA757\uA759]/g },
        { 'base': 'r', 'letters': /[\u0072\u24E1\uFF52\u0155\u1E59\u0159\u0211\u0213\u1E5B\u1E5D\u0157\u1E5F\u024D\u027D\uA75B\uA7A7\uA783]/g },
        { 'base': 's', 'letters': /[\u0073\u24E2\uFF53\u00DF\u015B\u1E65\u015D\u1E61\u0161\u1E67\u1E63\u1E69\u0219\u015F\u023F\uA7A9\uA785\u1E9B]/g },
        { 'base': 't', 'letters': /[\u0074\u24E3\uFF54\u1E6B\u1E97\u0165\u1E6D\u021B\u0163\u1E71\u1E6F\u0167\u01AD\u0288\u2C66\uA787]/g },
        { 'base': 'tz', 'letters': /[\uA729]/g },
        { 'base': 'u', 'letters': /[\u0075\u24E4\uFF55\u00F9\u00FA\u00FB\u0169\u1E79\u016B\u1E7B\u016D\u00FC\u01DC\u01D8\u01D6\u01DA\u1EE7\u016F\u0171\u01D4\u0215\u0217\u01B0\u1EEB\u1EE9\u1EEF\u1EED\u1EF1\u1EE5\u1E73\u0173\u1E77\u1E75\u0289]/g },
        { 'base': 'v', 'letters': /[\u0076\u24E5\uFF56\u1E7D\u1E7F\u028B\uA75F\u028C]/g },
        { 'base': 'vy', 'letters': /[\uA761]/g },
        { 'base': 'w', 'letters': /[\u0077\u24E6\uFF57\u1E81\u1E83\u0175\u1E87\u1E85\u1E98\u1E89\u2C73]/g },
        { 'base': 'x', 'letters': /[\u0078\u24E7\uFF58\u1E8B\u1E8D]/g },
        { 'base': 'y', 'letters': /[\u0079\u24E8\uFF59\u1EF3\u00FD\u0177\u1EF9\u0233\u1E8F\u00FF\u1EF7\u1E99\u1EF5\u01B4\u024F\u1EFF]/g },
        { 'base': 'z', 'letters': /[\u007A\u24E9\uFF5A\u017A\u1E91\u017C\u017E\u1E93\u1E95\u01B6\u0225\u0240\u2C6C\uA763]/g }
    ];

    for (var i = 0; i < defaultDiacriticsRemovalMap.length; i++) {
        str = str.replace(defaultDiacriticsRemovalMap[i].letters, defaultDiacriticsRemovalMap[i].base);
    }

    return str;

}
