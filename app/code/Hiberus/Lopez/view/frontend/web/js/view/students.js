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
        iconButtonActionText: ko.observable(),
        buttonActionTextWhenVisible: $t('Hide Marks'),
        iconWhenButtonActionIsVisible: 'fas fa-eye',
        buttonActionTextWhenNotVisible: $t('Show Marks'),
        iconWhenButtonActionIsNotVisible: 'fas fa-eye-slash',
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
        studentWithHighestMark: ko.observable(),
        highestMarkSection: ko.observable(false),
        averageMarkStudents: ko.observable(),
        highestExamId: ko.observable(false),
        highestMarks: ko.observableArray(),

        /**
         *
         * @returns {*}
         */
        initialize: function () {
            this._super();
            this.customFade();
            this.examsList(this.getStudentsList());
            this.getAverageStudents();
            this.buttonActionText(this.buttonActionTextWhenVisible);
            this.iconButtonActionText(this.iconWhenButtonActionIsNotVisible);
            this.Pager();
            return this;
        },
        getMostHighestMarks: function () {
            const studentsExamsSortered = underscore.sortBy(this.getStudentsList(), 'mark');
            const size = underscore.size(studentsExamsSortered);
            const highestMarks = studentsExamsSortered.slice(size - 3, size);
            this.highestMarks(highestMarks);
            this.selectHighestMark();
        },
        selectHighestMark: function () {
            const self = this;
            underscore.map(this.highestMarks(), function (exam, index) {
                const element = jQuery('.exam_' + exam.id_exam + ' .highest-mark');
                element.removeClass('hidden');
                if (exam.id_exam !== self.highestExamId()) {
                    element.addClass('featuredMark');
                }
            });
        },
        getStudentsList: function () {
            return this.exams;
        },
        showOrHideStudentsMark: function () {
            this.marksVisible(!this.marksVisible());
            if (this.marksVisible()) {
                this.buttonActionText(this.buttonActionTextWhenVisible);
                this.iconButtonActionText(this.iconWhenButtonActionIsNotVisible);
            } else {
                this.buttonActionText(this.buttonActionTextWhenNotVisible);
                this.iconButtonActionText(this.iconWhenButtonActionIsVisible);
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
            const exams         = this.getStudentsList();
            const exam          = underscore.max(exams, function (exam, index) {
                return exam.mark;
            });
            const isInPage      = this.searchPageStudentExamById(exam.id_exam);
            const message       = $t('Has the highest grade with a');
            const pageMessage   = $t('He is on page');
            let completeMessage = exam.firstname + ' ' + exam.lastname + ' ' + message + ' ' + exam.mark;
            completeMessage     += '. ' + pageMessage + ' ' + isInPage;
            this.studentWithHighestMark(completeMessage);

            jQuery('.highest-mark').addClass('hidden');
            const element = jQuery('.exam_' + exam.id_exam + ' .highest-mark');
            element.removeClass('hidden');
            element.removeClass('featuredMark');
            this.highestExamId(exam.id_exam);
            this.highestMarkSection(true);
        },
        isExamPass: function (mark) {
            return parseFloat(mark) >= 5;
        },
        hideHighestMarkSection: function () {
            jQuery('.highest-mark').addClass('hidden');
            this.highestMarkSection(false);
        },
        getAverageStudents: function () {
            const exams = this.getStudentsList();
            const size  = underscore.size(exams);
            const sumMarks = underscore.reduce(exams, function (itemMemory, item) {
                const markMemory = !!itemMemory.mark ? parseFloat(itemMemory.mark) : itemMemory;
                const mark       = parseFloat(item.mark);
                return markMemory + mark;
            });
            const average = (sumMarks / size).toFixed(2);
            this.averageMarkStudents(average);
        },
        getRange: function (start,  end) {
            let range = [];
            for (let i = start; i <= end; i++) {
                range.push(i);
            }
            return range;
        },
        getTotalPages: function () {

            const total_pages = Math.ceil(underscore.size(this.getStudentsList()) / this.DataPerPage());

            this.totalOptions(Math.ceil(total_pages / 3));

            this.allPages(this.getRange(1, total_pages));

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
                return this.allPages().slice(last_value, last_value + 4);
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
                jQuery('.exam_' + self.highestExamId() + ' .highest-mark').removeClass('hidden');
                self.selectHighestMark();
            };
        },
        getIsPageShowing: function (pageToCheck) {
            return  underscore.find(this.totalPages(), function (page, index) {
                return page === pageToCheck;
            });
        },
        searchIndexInArrayPages: function (pageToSearch) {
            return underscore.findIndex(this.allPages(), function (page) {
                return page === pageToSearch;
            });
        },
        searchPageStudentExamById: function (idExam) {
            const studentsExams = this.getStudentsList();
            const examKey       = underscore.findIndex(studentsExams, function (item) {
                return item.id_exam === idExam;
            });
            return Math.ceil(examKey / this.DataPerPage());
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
