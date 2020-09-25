define([
    'jquery',
    'uiComponent',
    'ko',
    'underscore',
    'mage/translate'
], function ($, Component, ko, underscore, $t) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Hiberus_Lopez/students-list'
        },
        marksVisible: ko.observable(true),
        buttonActionText: ko.observable(),
        buttonActionTextWhenVisible: $t('Hide Marks'),
        buttonActionTextWhenNotVisible: $t('Show Marks'),
        listStyle: ko.observable(true),
        tableStyle: ko.observable(false),
        CurrentPage: ko.observable(1),
        DataPerPage: ko.observable(5),
        allPages: ko.observableArray(),
        showNext: ko.observable(true),
        totalOptions: ko.observable(),
        currentOption: ko.observable(),
        examsList: ko.observableArray(),
        totalPages: ko.observableArray(),

        /**
         *
         * @returns {*}
         */
        initialize: function () {
            this._super();
            this.customFade();
            this.examsList(this.getStudentsList());
            this.buttonActionText(this.buttonActionTextWhenVisible);
            this.Pager();
            return this;
        },
        getStudentsList: function () {
            return this.exams;
        },
        showOrHideStudentsMark: function () {
            this.marksVisible(!this.marksVisible());
            if (this.marksVisible()) {
                this.buttonActionText(this.buttonActionTextWhenVisible);
            } else {
                this.buttonActionText(this.buttonActionTextWhenNotVisible);
            }
        },
        changeToListStyle: function () {
            this.listStyle(true);
            this.tableStyle(false);
        },
        changeToTableStyle: function () {
            this.listStyle(false);
            this.tableStyle(true);
        },
        getHighestNote: function () {
            const exams = this.getStudentsList();
            const exam  = underscore.max(exams, function (exam, index) {
                return exam.mark;
            });

            this.selectExamById(exam.id_exam);
        },
        selectExamById: function (id_exam) {
            jQuery('.exam_' + id_exam).css('color', 'green');
        },
        getTotalPages: function () {

            const total_pages = Math.ceil(underscore.size(this.getStudentsList()) / this.DataPerPage()) + 1;

            this.totalOptions(Math.ceil(total_pages / 3));

            this.allPages(underscore.range(total_pages));

            const firstKey = underscore.first(this.allPages());

            this.allPages(this.allPages().slice(firstKey + 1, total_pages));

            let array_pages_show = [];

            if (this.CurrentPage() === 1) {
                array_pages_show = this.allPages().slice(this.CurrentPage() - 1, this.CurrentPage() + 2);
            } else {
                array_pages_show = this.allPages().slice(this.CurrentPage() - 1 , this.CurrentPage() * 1);
            }

            this.currentOption(1);
            return array_pages_show;
        },
        getNextPages: function() {
            if (!underscore.size(this.allPages())) {
                return this.getTotalPages();
            }
            if (this.currentOption() <= this.totalOptions()) {
                const last_value = underscore.last(this.totalPages());
                this.currentOption(this.currentOption() + 1);
                return this.allPages().slice(last_value, last_value + 3);
            }
            return this.totalPages();
        },
        getPrevPages: function() {
            if (!underscore.size(this.allPages())) {
                return this.getTotalPages();
            }

            if (this.currentOption() <= 1) {
                return this.totalPages();
            }

            const first_value = underscore.first(this.totalPages());
            if (this.currentOption() > 1) {
                this.currentOption(this.currentOption() - 1);
            }
            return this.allPages().slice(first_value - 4, first_value - 1);
        },
        Pager: function() {
            const self = this;
            this.CurrentPage(1);
            self.examsList = ko.pureComputed(function() {
                const startIndex = self.CurrentPage() === 1 ? 0 : (self.CurrentPage() - 1) * self.DataPerPage();
                return self.getStudentsList().slice(startIndex, startIndex + self.DataPerPage())
            });

            self.totalPages(self.getNextPages());

            self.Next = function() {
                self.totalPages(self.getNextPages());
            };

            self.Previous = function() {
                self.totalPages(self.getPrevPages());
            };

            self.getExamsPaginated = function (page) {
                self.CurrentPage(page);
            };
        },
        customFade: function() {
            ko.bindingHandlers.fadeVisible = {
                //On initialization, check to see if bound element should be hidden by default
                'init': function(element, valueAccessor, allBindings, viewModel, bindingContext){
                    const show = ko.utils.unwrapObservable(valueAccessor());
                    if(!show){
                        element.style.display = 'none';
                    }
                },
                //On update, see if fade in/fade out should be triggered. Factor in current visibility
                'update': function(element, valueAccessor, allBindings, viewModel, bindingContext) {
                    const show = ko.utils.unwrapObservable(valueAccessor());
                    const isVisible = !(element.style.display == "none");

                    if (show && !isVisible){
                        setTimeout(function () {
                            $(element).fadeIn(750);
                        }, 210);
                    }else if(!show && isVisible){
                        $(element).fadeOut(209);
                    }
                }
            }
        },
    });
});