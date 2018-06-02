/*!
 * Step Form Wizard
 * Jiri Wasniowski - <ajoke3@gmail.com>
 * http://codecanyon.net/item/step-form-wizard/8591111
 * Version 2.3 - built March 2 2016
 */
(function($) {

    var defaults = {
        duration: 1000,
        transition: 'slide',
        linkNav: true, // true, false, prev
        showNav: true, // true = top, false , right, bottom, left
        showNavNumbers: true,
        showButtons: true,
        showLegend: true,
        nextBtn: $('<a class="next-btn sf-right sf-btn" href="#">NEXT</a>'),
        prevBtn: $('<a class="prev-btn sf-left sf-btn" href="#">PREV</a>'),
        finishBtn: $('<input class="finish-btn sf-right sf-btn" type="submit" value="FINISH"/>'),
        onNext: function(from, data) {},
        onPrev: function(from, data) {},
        onFinish: function(from, data) {},
        onSlideChanged: function(to, data) {},
        startStep: 0,
        rtl: false,
        height: 'first', // auto, tallest, first, 200
        theme: 'sea', // sea, sky, simple, circle, sun
        markPrevSteps: false,
        stepElement: 'fieldset',
        stepNameElement: 'legend',
        disableEnter: false,
        smallMobileNav: true,
        debug: false,
        spinner:    '<div class="spinner">'
                        +'<div class="ball-1"></div>'
                        +'<div class="ball-2"></div>'
                        +'<div class="ball-3"></div>'
                    +'</div>'
    }

    function stepFormWizard(element, options) {

        var w = this;
        w.config = $.extend({}, defaults, options);
        w.element = element;
        w.steps = element.find(w.config.stepElement);
        if(!w.config.showLegend) {
            w.element.addClass('sf-hide-legend')
        }

        w.btnFinishTmp = w.config.finishBtn;
        w.btnPrevTmp = w.config.prevBtn;
        w.btnNextTmp = w.config.nextBtn;

        // transition test
        var body = document.body || document.documentElement;
        if(typeof body.style.transition === "undefined" && w.config.transition != "fade") {
            w.config.duration = 0;
        }

        w.viewPort;
        w.navWrap;

        if(w.config.startStep >= w.steps.length) {
            w.config.startStep = w.steps.length - 1;
        }
        w.stepActive = w.config.startStep;

        w.labels = [];
        w.themes = {none: 't0', sun: 't1', sea: 't2', sky: 't3', simple: 't4', circle: 't5'}

        w.init();
        element.trigger('sf-loaded');

        return w;
    }

    stepFormWizard.prototype.init = function() {
        var w = this;
        w.element.append($("<div>").addClass('sf-viewport'));
        w.viewPort = $('.sf-viewport', w.element);

        w.element.wrap($('<div>', {class: 'sf-wizard clearfix' + (w.config.rtl?' sf-rtl':''), id: w.element.attr('id') + '-box'}))
        w.wizard = w.element.parent();
        w.wizard.addClass('sf-' + w.themes[w.config.theme] + ' sf-' + w.config.transition + ' sf-s-' + w.config.startStep);

        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            w.wizard.addClass('sf-mob');
        } else {
            w.wizard.addClass('sf-nomob');
        }

        if(!w.config.showNavNumbers) {
            w.wizard.addClass('sf-nonumbers');
        }

        $(w.viewPort).append($("<div>", {class: "sf-fieldwrap clearfix", id: w.element.attr('id') + '-field'}));

        w.fieldWrap = $('.sf-fieldwrap', w.element);

        w.fieldWrap.css({transition: 'transform ' + w.config.duration + 'ms'});

        var controls = $("<div>", {class: 'sf-controls clearfix'});
        if(w.config.showNav == 'bottom') {
            controls.insertBefore($('.sf-viewport', w.wizard));
        } else {
            w.element.append(controls);
        }

        w.controls = $('.sf-controls', w.element);

        if(w.config.theme == 'circle') {
            w.viewPort.wrap($('<div>', {class: 'sf-viewport-out'}));
        }

        if(!w.config.showButtons) {
            w.controls.addClass('sf-hide-buttons');
        }

        $(w.config.stepNameElement, w.element).addClass('sf-step-name')

        w.touch = {
            start: 0,
            movex: 0,
            move: 0,
            index: 0,
            longTouch: undefined,
            offset: 0,
            navWidth: 0,
            diff: 0
        }
        if(w.config.showNav !== false) {
            w.initNav();
            if(w.config.showNav == 'bottom' || w.config.showNav == 'top' || w.config.showNav == true) {
                w.initTouchNav();
                setTimeout(function() {$('.sf-nav').css({clear: 'both'})}, 3000);
            }
        }

        w.steps.each(function(index) {
            w.wrapStep(this, index);
        });

        w.initBtnFinish(w.config.startStep);
        w.initBtnNext(w.config.startStep);
        w.initBtnPrev(w.config.startStep);
        w.checkBtns();

        w.setProportion();

        $(window).resize(function() {
            w.careNav(w.stepActive, w.stepActive);
            w.setProportion();
        })

        w.addBtnsClick();

        var query = '';
        if(typeof w.config.disableEnter === "string") {
            var notE = w.config.disableEnter.split(',');
            query = notE.map(function(el) {
                return ":not(" + el.trim() + ')';
            }).join('')
        }
        w.element.on('keydown', ':input:not(textarea)' + query, function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 13) {
                e.preventDefault();
                if(w.config.disableEnter === false) {
                    w.next();
                }
            }
        });

    }

    stepFormWizard.prototype.initTouchNav = function() {
        var w = this;

        $('.sf-nav', w.wizard).on("touchstart", function(event) {
            w.touch = w.touch;
            w.touch.longTouch = false;
            $('.sf-nav', w.navWrap).css({transition: 'none'})
            w.touch.start =  event.originalEvent.touches[0].pageX;
        });

        $('.sf-nav', w.wizard).on("touchmove", function(event) {
            w.touch = w.touch;
            w.touch.movex =  event.originalEvent.touches[0].pageX;
            w.touch.move = w.touch.start - w.touch.movex;
            w.touch.diff = (parseInt(w.touch.offset, 10) - w.touch.move);
            if(w.touch.diff > 0) {
                w.touch.diff = 0;
            }
            if(w.touch.diff < -w.touch.navWidth) {
                w.touch.diff = -w.touch.navWidth;
            }
            prop = 'translateX(' + w.touch.diff + 'px)';
            $('.sf-nav', w.navWrap).css({
                '-webkit-transform': prop,
                '-moz-transform': prop,
                '-ms-transform': prop,
                '-o-transform': prop,
                'transform': prop
            });
        });
        $('.sf-nav', w.wizard).on("touchend", function(event) {
            w.touch.offset = w.touch.diff;
            $('.sf-nav', w.navWrap).css({transition: 'all ' + w.config.duration + 'ms'})
        });
    }

    stepFormWizard.prototype.step = function(index) {
        return $('.sf-step', this.wizard).filter(function() {
            return $(this).data('step') == index;
        })
    }

    stepFormWizard.prototype.navStep = function(index) {
        return $('.sf-nav-step', this.wizard).filter(function() {
            return $(this).data('step') == index;
        })
    }

    stepFormWizard.prototype.wrapStep = function(step, index) {
        $(step).addClass('sf-step-el');

        var wrap_div = $('<div>', {class: 'sf-step'}).data('step', index);

        if(index == this.config.startStep) {
            wrap_div.addClass('sf-step-front');
        }

        $(step).wrap(wrap_div)
            .parent()
            .appendTo(this.fieldWrap);

    }
    
    stepFormWizard.prototype.hideStep = function(index, val, reindex) {
        var w = this;
        if(index == w.stepActive) {
            return false;
        }
        if(index == "next") {
            if(w.step(w.stepActive + 1).length) {
                index = w.stepActive + 1;
            }
        }
        if(index == "prev") {
            if(w.step(w.stepActive - 1).length) {
                index = w.stepActive - 1;
            }
        }
        if(val === false) {
            w.step(index).removeClass('sf-step-disabled sf-step-hidden');
        } else {
            w.step(index).addClass('sf-step-disabled sf-step-hidden');
        }
        w.stepNavAnimate(index, val, reindex);
        w.checkBtns();
    }
    
    stepFormWizard.prototype.stepNavAnimate = function(index, val, reindex) {
        var w = this;
        var s = w.navStep(index);
        if(val === false) {
            s.css('display', 'none');
            s.removeClass('sf-nav-step-disabled sf-nav-step-hidden')
            if(w.config.theme == 'circle') {
                s.css('display', '');
            }
            s.fadeIn(500)
            if(typeof reindex === "undefined" || reindex === true) {
                w.reindexNavNum();
            }
        } else {
            s.addClass('sf-nav-step-hidden');
            if(w.config.theme == 'circle') {
                s.addClass('sf-nav-step-disabled sf-nav-step-hidden').css('display', '');
            } 
            s.fadeOut(500, function() {
                s.addClass('sf-nav-step-disabled');
                if(typeof reindex === "undefined" || reindex === true) {
                    w.reindexNavNum();
                }
            })
        }
        w.careNav(w.stepActive, w.stepActive)
    }
    
    stepFormWizard.prototype.reindexNavNum = function() {
        $('.sf-nav-step', this.wizard).not('.sf-nav-step-hidden').each(function(i) {
              $(this).find('.sf-nav-number-inner').text(i + 1);
              if(i + 1 > 9) {
                  $(this).addClass('sf-li-numbers-two');
              }
        })
    }

    stepFormWizard.prototype.addStep = function(index, body, reindex) {
        var w = this;
        index = parseInt(index);
        var stepElement = w.config.stepElement.match(/(^\.)?(.+)/);
        var step;
        if(typeof stepElement[1] !== "undefined") {
            step = $('<div>', {class: stepElement[1]})
        }
        if(typeof stepElement[1] === "undefined") {
            step = $('<'+stepElement[2]+'>')
        }
        step.html(body);
        // shift numbers of origin steps
        $('.sf-step', w.wizard).each(function() {
            var stepNum = $(this).data('step');
            if(stepNum >= index) {
                $(this).data('step', ++stepNum);
            }
        })
        $('.sf-nav-step', w.wizard).each(function() {
            var stepNavNum = $(this).data('step');
            if(stepNavNum >= index) {
                $(this).data('step', ++stepNavNum)
                if(w.stepActive + 1 != stepNavNum) {
                    $(this).removeClass('sf-active');
                }
            }
        })
        if(index <= w.stepActive) {
            w.stepActive++;
        }
        w.config.startStep = w.stepActive;
        w.wrapStep(step, index);
        w.wrapNavItem(w.step(index), index);
        
        w.stepNavAnimate(index, false, reindex);
        
        w.addNavClick();
        w.checkBtns();
        w.setProportion();
    }

    stepFormWizard.prototype.removeStep = function(index, reindex) {
        var w = this;
        var step = w.step(index);
        var stepNav = w.navStep(index);

        if(w.stepActive == index) {
            w.log("You can't remove active step");
            return false;
        }

        step.remove();
        w.stepNavAnimate(index, true, reindex);
        setTimeout(function() {
            stepNav.remove();
        }, 500);
        // shift numbers of origin steps
        $('.sf-step', w.wizard).each(function() {
            var stepNum = $(this).data('step');
            if(stepNum >= index) {
                $(this).data('step', --stepNum);
            }
        })
        $('.sf-nav-step', w.wizard).each(function() {
            var stepNavNum = $(this).data('step');
            if(stepNavNum >= index) {
                $(this).data('step', --stepNavNum);
                if(w.stepActive != stepNavNum) {
                    $(this).removeClass('sf-active');
                }
            }
        })
        
        if(w.stepActive > index) {
            w.stepActive--;
            w.navStep(w.stepActive).addClass('sf-active');
        }

        w.config.startStep = w.stepActive;
        w.checkBtns();
        w.setProportion();
    }

    stepFormWizard.prototype.checkBtns = function() {
        var w = this;

        if(w.checkNext() !== false) {
            w.btnNext.fadeIn(100);
        } else {
            w.btnNext.fadeOut(0);
        }

        if(w.checkPrev() !== false) {
            w.btnPrev.fadeIn(100);
        } else {
            w.btnPrev.fadeOut(100);
        }

        if(w.checkNext() === false) {
            w.btnFinish.fadeIn(100);
        } else {
            w.btnFinish.fadeOut(0);
        }
        if(w.btnNext.hasClass('sf-btn-disabled')) {
            w.addClickNext(false);
        } else {
            w.addClickNext();
        }
        if(w.btnPrev.hasClass('sf-btn-disabled')) {
            w.addClickPrev(false);
        } else {
            w.addClickPrev();
        }
        if(w.btnFinish.hasClass('sf-btn-disabled')) {
            w.addClickFinish(false);
        } else {
            w.addClickFinish();
        }
    }

    stepFormWizard.prototype.checkNext = function() {
        var w = this;

        var minStep = 99;
        $('.sf-step', w.wizard).each(function() {
            var step = $(this);
            if(w.stepActive < step.data('step') && !step.hasClass('sf-step-disabled')) {
                if(step.data('step') < minStep) {
                    minStep = step.data('step');
                }
            }
        })
        if(minStep < 99) {
            return minStep; // minimum of steps
        }
        return false;
    }

    stepFormWizard.prototype.checkPrev = function() {
        var w = this;
        if(w.stepActive < 1) {
            return false;
        }
        // find first useable step
        var maxStep = 0;
        $('.sf-step', w.wizard).each(function() {
            var step = $(this);
            if(w.stepActive > step.data('step') && !step.hasClass('sf-step-disabled')) {
                if(step.data('step') > maxStep) {
                    maxStep = step.data('step');
                }
            }
        })
        if(maxStep >=0) {
            return maxStep; // max step of steps
        }
        return false;
    }

    stepFormWizard.prototype.touchFix = function(self) {
        var el = self;
        var next = $(el).next();
        $(self).remove();
        setTimeout(function() {next.before(el)}, 1)
    }

    stepFormWizard.prototype.addBtnsClick = function() {
        var w = this;
        w.addClickNext();
        w.addClickPrev();
        w.addClickFinish();
    }

    stepFormWizard.prototype.addClickNext = function(val) {
        var w = this;
        w.touchFix(w);
        $(w.wizard).off('click', '.next-btn');
        $(w.wizard).on('click', '.next-btn', function(e, data) {

            if(typeof val === "undefined" || val === true) {
                w.goTo('next', data);
            }
            e.preventDefault();
        })
    }

    stepFormWizard.prototype.addClickPrev = function(val) {
        var w = this;
        $(w.wizard).off('click', '.prev-btn');
        $(w.wizard).on('click', '.prev-btn', function(e, data) {
            if(typeof val === "undefined" || val === true) {
                w.goTo('prev', data);
            }
            e.preventDefault();
        })
    }

    stepFormWizard.prototype.addClickFinish = function(val) {
        var w = this;
        $(w.wizard).off('click', '.finish-btn');
        $(w.wizard).on('click', '.finish-btn', function(e, data) {
            if(typeof val === "undefined" || val === true) {
                w.finish(data);
            }
            e.preventDefault();
        })
    }

    stepFormWizard.prototype.addSpinner = function(index, val) {
        var w = this;
        if(val === false) {
            if(index == "next") {
                w.nextLabel(w.labels['next']);
            }
            if(index == "prev") {
                w.prevLabel(w.labels['prev']);
            }
            if(index == "finish") {
                w.finishLabel(w.labels['finish']);
            }
            if(!isNaN(index)) {
                w.navLabel(index, w.labels[index]);
            }
        } else {
            if(index == "next") {
                w.labels['next'] = w.nextLabel();
                w.nextLabel(w.config.spinner);
            }
            if(index == "prev") {
                w.labels['prev'] = w.prevLabel();
                w.prevLabel(w.config.spinner);
            }
            if(index == "finish") {
                w.labels['finish'] = w.finishLabel();
                w.finishLabel(w.config.spinner);
            }
            if(!isNaN(index)) {
                w.labels[index] = w.navLabel(index);
                w.navLabel(index, w.config.spinner)
            }
        }
    }

    stepFormWizard.prototype.isAnimating = function() {
        if(this.wizard.hasClass('sf-animating')) {
            return true;
        }
        return false;
    }

    stepFormWizard.prototype.addAnimating = function() {
        this.wizard.addClass('sf-animating');
    }

    stepFormWizard.prototype.removeAnimating = function() {
        this.wizard.removeClass('sf-animating');
    }

    stepFormWizard.prototype.stopTransitionEffect = function() {
        this.element.find('.sf-fieldwrap').removeAttr('style');
        this.element.find('.sf-fieldwrap').attr('style', '');
    }

    stepFormWizard.prototype.startTransitionEffect = function(removeAnimating) {
        var w = this;
        setTimeout(function() {
            w.element.find('.sf-fieldwrap').css({transition: 'transform ' + w.config.duration + 'ms'});
            if(removeAnimating) {
                w.removeAnimating();
            }
        }, 150)
    }

    stepFormWizard.prototype.markStep = function(index, val) {
        if(val == false) {
            this.navStep(index).removeClass('sf-nav-mark-step');
        } else {
            this.navStep(index).addClass('sf-nav-mark-step');
        }
    }

    stepFormWizard.prototype.disableStep = function(index, val) {
        var w = this;
        if(index == "next") {
            if(w.step(w.stepActive + 1).length) {
                index = w.stepActive + 1;
            }
        }
        if(index == "prev") {
            if(w.step(w.stepActive - 1).length) {
                index = w.stepActive - 1;
            }
        }
        if(val === false) {
            w.step(index).removeClass('sf-step-disabled');
            w.navStep(index).removeClass('sf-nav-step-disabled');
        } else {
            w.step(index).addClass('sf-step-disabled');
            w.navStep(index).addClass('sf-nav-step-disabled');
        }
        w.checkBtns();
    }

    stepFormWizard.prototype.activeStep = function(index, val) {
        var w = this;
        if(val === false) {
            w.navStep(index).addClass('sf-nav-unlink').removeClass('sf-nav-link');
        } else {
            w.navStep(index).addClass('sf-nav-link').removeClass('sf-nav-unlink');
        }
        w.addNavClick();
    }

    stepFormWizard.prototype.activeNext = function(val, allowFinish) {
        var w = this;
        if(val == false) {
            w.btnNext.addClass('sf-btn-disabled');
            if(allowFinish == false) {
                w.activeFinish(false);
            }
        } else {
            w.btnNext.removeClass('sf-btn-disabled');
            if(typeof allowFinish === "undefined" || allowFinish == true) {
                w.activeFinish();
            }
        }
        w.checkBtns();
    }

    stepFormWizard.prototype.activePrev = function(val) {
        var w = this;
        if(val == false) {
            w.btnPrev.addClass('sf-btn-disabled');
        } else {
            w.btnPrev.removeClass('sf-btn-disabled');
        }
        w.checkBtns();
    }

    stepFormWizard.prototype.activeFinish = function(val) {
        var w = this;
        if(val == false) {
            w.btnFinish.addClass('sf-btn-disabled');
        } else {
            w.btnFinish.removeClass('sf-btn-disabled');
        }
        w.checkBtns();
    }

    stepFormWizard.prototype.navLabel = function(index, label) {
        var w = this;
        if(typeof label === "undefined") {
            return w.navStep(index).find('.sf-nav-subtext').html();
        } else {
            w.navStep(index).find('.sf-nav-subtext').html(label);
            w.setNavWidth();
        }

    }

    stepFormWizard.prototype.navNumber = function(index, num) {
        this.navStep(index).find('.sf-nav-number-inner').html(num);
    }

    stepFormWizard.prototype.nextLabel = function(label) {
        if(typeof label === "undefined") {
            return this.btnNext.html();
        }
        this.btnNext.html(label);
    }

    stepFormWizard.prototype.prevLabel = function(label) {
        if(typeof label === "undefined") {
            return this.btnPrev.html();
        }
        this.btnPrev.html(label);
    }

    stepFormWizard.prototype.finishLabel = function(label) {
        var w = this;
        if(typeof label === "undefined") {
            if(w.btnFinish.is(':input')) {
                return this.btnFinish.val();
            }
            return this.btnFinish.html();
        }
        if(w.btnFinish.is(':input')) {
            this.btnFinish.val(label);
        } else {
            this.btnFinish.html(label);
        }
    }

    stepFormWizard.prototype.getActualStep = function() {
        return this.stepActive;
    }

    stepFormWizard.prototype.initNav = function() {
        var w = this;
        var sf_nav_wrap = $('<div>').addClass('sf-nav-wrap clearfix');
        if(w.config.smallMobileNav) {
            sf_nav_wrap.addClass('sf-nav-smmob');
        }
        var sf_nav = $('<ul>').addClass('sf-nav clearfix');
        sf_nav_wrap.append(sf_nav);
        if(w.config.showNav == 'bottom') {
            this.element.after(sf_nav_wrap);
        } else {
            this.element.before(sf_nav_wrap);
        }
        this.navWrap = $('.sf-nav-wrap', w.wizard);

        this.steps.each(function(index) {
            w.wrapNavItem(this, index)
        });

        this.addNavClick();

        this.careNav(this.stepActive, this.stepActive);
    }

    stepFormWizard.prototype.addNavClick = function() {
        var w = this;
        $('.sf-nav-step', w.wizard).off('click');
        $('.sf-nav-step.sf-nav-link', w.wizard).on('click', w.wizard, function(e) {
            w.goTo($(this).data('step'));
            e.preventDefault();
        })
    }

    stepFormWizard.prototype.wrapNavItem = function(step, index) {
        var w = this;
        var nav_li = $('<li>', {class: 'sf-nav-step', data: {step: index}});
        if(w.config.markPrevSteps && index < w.config.startStep ) {
            nav_li.addClass('sf-nav-mark-step');
        }
        if(w.config.showNavNumbers) {
            nav_li.addClass('sf-li-number');
            if(index > 8) {
                nav_li.addClass('sf-li-numbers-two')
            }
        } else {
            nav_li.addClass('sf-li-nonumber');
        }
        $('<span>')
            .addClass('sf-nav-subtext')
            .html(
            $(step)
                .find(w.config.stepNameElement)
                .first()
                .html()
        ).appendTo(nav_li);


        var nav_num = $('<div>')
            .addClass('sf-nav-number')
            .appendTo(nav_li);

        $('<span>')
            .addClass('sf-nav-number-inner')
            .html(index + 1)
            .appendTo(nav_num);

        $('<div>').appendTo(nav_li);


        if(index == w.config.startStep) {
            nav_li.addClass('sf-active');
        }
        if(w.config.linkNav == true) {
            nav_li.addClass('sf-nav-link');
        } else if(w.config.linkNav == "prev" && w.stepActive >= index) {
            nav_li.addClass('sf-nav-link');
        } else {
            nav_li.addClass('sf-nav-unlink');
        }
        var nav = $(".sf-nav-wrap", w.wizard);
        if(w.config.showNav == 'left') {
            nav.addClass('sf-nav-left');
            w.element.addClass('sf-nav-on-left');
        }
        if(w.config.showNav == 'right') {
            nav.addClass('sf-nav-right');
            w.element.addClass('sf-nav-on-right');
        }
        if(w.config.showNav == 'top' || w.config.showNav === true) {
            nav.addClass('sf-nav-top');
            w.element.addClass('sf-nav-on-top');
        }
        if(w.config.showNav == 'bottom') {
            nav.addClass('sf-nav-bottom');
            w.element.addClass('sf-nav-on-bottom');
        }
        w.element.addClass('sf-content');
        if(w.navStep(index + 1).length) {
            w.navStep(index + 1).before(nav_li);
            w.setNavWidth();
        } else {
            w.wizard.find(".sf-nav").append(nav_li);
        }
    }

    stepFormWizard.prototype.setProportion = function(animation) {
        var w = this;
        if(typeof animation === "undefined" || animation == false) {
            w.stopTransitionEffect();
        }

        this.stepWidth = w.viewPort.width();

        var height = 0;
        var tallestStep = 0;

        if(w.config.height == 'auto' && w.config.transition != '3d-cube' && w.steps.length) {
            w.step(w.stepActive).height('auto');
            var heightView = w.step(w.stepActive).outerHeight();
            w.viewPort.height(heightView);
            height = heightView;
        }
        if(w.config.height == 'first' && w.steps.length) {
            w.step(0).height('auto');
            height = w.step(0).height();

            w.viewPort.height(w.step(0).outerHeight());
        }
        if(!isNaN(parseInt(w.config.height)) && w.steps.length) {
            height = w.config.height;

            w.viewPort.height(height);
            w.step(0).height(height);
            var stepHeight = w.step(0).outerHeight(true);
            height = 2 * height - stepHeight;
        }
        if(this.config.height == 'tallest' || (this.config.height == 'auto' && this.config.transition == '3d-cube') && this.steps.length) {
            $('.sf-step', w.wizard).each(function(index) {
                $(this).css({height: 'auto', display: 'block'})
                if($(this).height() > height) {
                    height = $(this).height();
                    tallestStep = $(this);
                }
                $(this).css('display','')
            });
            this.viewPort.height(tallestStep.outerHeight());
        }

        var translateZ = ' translateZ( ' + ((w.stepWidth)/2) + 'px )';
        $('#sf-' + w.element.attr('id') + '-styles').remove();
        var cssPre = "#" + w.element.attr('id') + " .sf-fieldwrap ";
        if(w.config.transition == '3d-cube') {
            $("<style type='text/css' id='sf-" + w.element.attr('id') + "-styles'>"
                +cssPre + " {transform: rotateY( 0deg ) translateZ( -"+ ((w.stepWidth)/2) +"px );}"
                +cssPre + " .sf-step.sf-step-front{transform: rotateY( 0deg )" + translateZ + "}"
                +cssPre + " .sf-step.sf-step-right{transform: rotateY( 90deg )" + translateZ + "}"
                +cssPre + " .sf-step.sf-step-left{transform: rotateY( -90deg )" + translateZ + "}"
                +"</style>").appendTo("head");
        } else if(w.config.transition == 'slide') {
            $("<style type='text/css' id='sf-" + w.element.attr('id') + "-styles'>"
                +cssPre + " {}"
                +cssPre + " .sf-step.sf-step-front{}"
                +cssPre + " .sf-step.sf-step-right{transform: translateX("+w.stepWidth+"px)}"
                +cssPre + " .sf-step.sf-step-left{transform: translateX(-"+w.stepWidth+"px)}"
                +"</style>").appendTo("head");
        }


        if(height) {
            $('.sf-step', this.wizard).each(function(index) {
                $(this).height(height);
            });
        }

        w.startTransitionEffect();

    }

    stepFormWizard.prototype.goTo = function(index, data, ifFinish) {

        var w = this;
        if(isNaN(index)) {
            if(index == "next") {
                // if next has allow send form
                if(w.stepActive == $('.sf-step').length - 1) {
                    if(typeof ifFinish !== "undefined" && ifFinish) {
                        return this.finish(data);
                    } else {
                        this.log('last step - add parameter if you want finish')
                        return false;
                    }
                }
                index = w.checkNext();
            } else if(index == "prev") {
                if(w.stepActive < 1) {
                    this.log('first step - there is no more prev step')
                    return false;
                }
                index = w.checkPrev();
            } else {
                return false; // unknown value
            }
        }

        // greater number than count of steps or can't transition
        if(index >= $('.sf-step', w.wizard).length || index === false || w.step(index).is('.sf-step-disabled')) {
            return false
        }

        // last animation don't stop yet
        if(this.isAnimating() || this.stepActive == index) {
            return false;
        }

        var step_active = this.stepActive;

        // ****** events *******

        if(step_active > index) { // down
            for(var i = step_active; i > index; i--) {
                var step = w.step(i);
                if(!step.hasClass('sf-step-disabled')) {
                    if(w.config.onPrev(i, data) === false) {
                        index = i;
                    }
                }
            }
        }

        if(step_active < index) { // up
            for(var i = step_active; i < index; i++) {
                var step = w.step(i);
                if(!step.hasClass('sf-step-disabled')) {
                    if (w.config.onNext(i, data) === false) {
                        index = i;
                    }
                }
            }
        }

        // onNext or onPrev prevent transition
        if(step_active == index) {
            return false;
        }

        this.addAnimating();

        if(w.config.linkNav != false) {
            w.activeStep(index);
        }

        if(w.step(index).find(w.config.stepElement).attr('data-sf-step') == "summary") {
            w.summaryStep(index);
        }

        var event = jQuery.Event( 'sf-step-before' );
        w.element.trigger(event, [step_active, index, data]);
        if(event.isDefaultPrevented()) {
            w.removeAnimating();
            return false;
        }

        // ****** end events *******

        w.wizard.removeClass('sf-s-' + step_active).addClass('sf-s-trans-' + index);

        if(w.config.markPrevSteps) {
            $('.sf-nav-step', w.navWrap).each(function(i) {
                $(this).removeClass('sf-nav-mark-step');
                if(i < index) {
                    $(this).addClass('sf-nav-mark-step');
                }
            })
        }
        /* nav animate*/
        this.careNav(index, step_active);

        w.element.find('.sf-step').removeClass('sf-step-front sf-step-right sf-step-left');
        w.step(step_active).addClass('sf-step-front');

        stepShift = '';
        // shifting forward
        if(step_active < index) {
            if(w.config.rtl) {
                w.step(index).addClass('sf-step-left');
            } else {
                stepShift = '-'
                w.step(index).addClass('sf-step-right');
            }
        }
        // shifting backword
        else {
            if(w.config.rtl) {
                stepShift = '-'
                w.step(index).addClass('sf-step-right');
            } else {
                w.step(index).addClass('sf-step-left');
            }
        }

        if(w.config.transition == '3d-cube') {
            if(w.isSupportTransition() !== false) {
                $('#sf-' + w.element.attr('id') + '-trans-styles').remove();
                var cssPre = "#" + w.element.attr('id') + " .sf-fieldwrap";

                $("<style type='text/css' id='sf-" + w.element.attr('id') + "-trans-styles'>"
                    +"@keyframes cube-"+w.element.attr('id')+" {"
                    +'33% {transform: translateZ(-' + (w.stepWidth - w.stepWidth/4) + 'px)}'
                    +'66% {transform: translateZ(-'+(w.stepWidth - w.stepWidth/4) +'px) rotateY('+stepShift+'90deg)}'
                    +'100% {transform: translateZ(-' + w.stepWidth / 2 + 'px) rotateY(' + stepShift + '90deg)}'
                    +"}"
                    +cssPre +'.sf-trans-cube-process {'
                    +'animation-name: cube-'+w.element.attr('id')+';'
                    +'animation-duration: ' + this.config.duration + 'ms;}'
                    +"</style>").appendTo("head");

                $('.sf-fieldwrap', this.wizard).addClass('sf-trans-cube-process');
                setTimeout(function() {
                    $('.sf-fieldwrap', this.wizard).removeClass('sf-trans-cube-process')
                    w.afterTransition(w.stepActive, index, data);
                }, this.config.duration);
            } else {
                w.afterTransition(index, index, data);
            }
        } else if(w.config.transition == 'fade') {
            w.step(w.stepActive).fadeOut(w.config.duration / 2);
            setTimeout(function() {
                w.step(index).fadeIn(w.config.duration / 2);
            }, w.config.duration / 2)
            setTimeout(function() {
                w.afterTransition(index, index, data);
            }, w.config.duration)
        } else if(w.config.transition == 'slide') {
            if(w.isSupportTransition() !== false) {
                $('#sf-' + w.element.attr('id') + '-trans-styles').remove();
                var cssPre = "#" + w.element.attr('id') + " .sf-fieldwrap";

                $("<style type='text/css' id='sf-" + w.element.attr('id') + "-trans-styles'>"
                    +"@keyframes slide-"+w.element.attr('id')+" {"
                    +'100% {transform: translateX(' + stepShift+(w.stepWidth) + 'px)}'
                    +"}"
                    +cssPre +'.sf-trans-slide-process {'
                    +'animation-name: slide-'+w.element.attr('id')+';'
                    +'animation-duration: ' + this.config.duration + 'ms;}'
                    +"</style>").appendTo("head");

                $('.sf-fieldwrap', this.wizard).addClass('sf-trans-slide-process');
                setTimeout(function() {
                    $('.sf-fieldwrap', this.wizard).removeClass('sf-trans-slide-process')
                    w.afterTransition(w.stepActive, index, data);
                }, this.config.duration);
            } else {
                w.afterTransition(index, index, data);
            }
        } else if(w.config.transition == 'none') {
            w.afterTransition(index, index, data);
        }


        w.stepActive = index;

        $('.sf-nav-step', w.wizard).removeClass('sf-active');
        w.navStep(index).addClass('sf-active');

        if(w.config.height == 'auto' && w.steps.length && w.config.transition != '3d-cube') {
            var step = w.step(w.stepActive);
            step.height('auto');
            var step_height = step.height();
            var height = w.step(w.stepActive).outerHeight(true);
            w.viewPort.height(height);
            step.height(step_height);
        }

        w.checkBtns();

        return true;
    }

    stepFormWizard.prototype.isSupportTransition = function() {
        var body = document.body || document.documentElement;
        if(typeof body.style.transition === "undefined") {
            return false;
        }
        return true;
    }

    stepFormWizard.prototype.afterTransition = function(to, index, data) {
        var w = this;
        w.stopTransitionEffect();
        w.wizard.removeClass('sf-s-trans-' + to).addClass('sf-s-' + to);
        w.element.find('.sf-step').removeClass('sf-step-front sf-step-right sf-step-left');
        w.step(to).addClass('sf-step-front');
        w.startTransitionEffect(true);
        w.config.onSlideChanged(to, data);
        w.element.trigger('sf-step-after', [w.stepActive, data]);
    }

    stepFormWizard.prototype.summaryStep = function(index) {
        var w = this;
        var html = w.step(index).html();
        html = html.replace(/({{)([^}]+)(}})/g, '<span data-sf-input="$2"></span>');
        var re = /<span data-sf-input="([^"|]+)\|?([^"]+)?"/g;
        var m;

        while ((m = re.exec(html)) !== null) {
            if (m.index === re.lastIndex) {
                re.lastIndex++;
            }
            var el = $('[name="' + m[1] +'"]', w.wizard);
            var val;
            var valArr = [];
            if(el.is('select')) {
                el = el.find('option');
            }
            if(el.length > 1) {
                var somethingChecked = false;
                el.each(function() {
                    var t = $(this);
                    if(t.is(":checkbox") || t.is(":radio") || t.is('option')) {
                        if(t.is(":checked")) {
                            var text = $(this).data('sf-text');
                            if(typeof text !== "undefined" && text !== false) {
                                valArr.push(text);
                            } else {
                                valArr.push(t.val());
                            }
                            somethingChecked = true;
                        }
                    } else {
                        valArr.push(t.val());
                    }

                });
                val = valArr.join(', ');

                if(!somethingChecked) {
                    if(typeof m[2] === "undefined") {
                        val = "---";
                    } else {
                        val = m[2];
                    }
                }
            } else {
                if(el.is(":checkbox") || el.is(":radio")) {
                    if(el.is(":checked")) {
                        var text = el.attr('data-sf-text');
                        if (typeof text !== "undefined" && text !== false) {
                            val = text;
                        } else {
                            val = el.val();
                        }
                    } else {
                        if(typeof m[2] === "undefined") {
                            val = "---";
                        } else {
                            val = m[2];
                        }
                    }
                } else {
                    if(el.val() == "" && typeof m[2] !== "undefined") {
                        val = m[2];
                    } else {
                        val = el.val();
                    }

                }
            }

            var safeReg = m[0].replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
            var reg = new RegExp('(' + safeReg + '>)(.*?)(<\/span>)',"g");
            html = html.replace(reg, '$1' + val + '$3');
        }
        w.step(index).html(html);
    }

    stepFormWizard.prototype.careNav = function(index, step_active) {
        var w = this;

        if(w.config.showNav !== false) {
            var navWidth = w.navWrap.width();
            var navStepWidth = new Array();
            var reindex = index;
            var restep_active = step_active;
            if(w.config.showNav === true || w.config.showNav == 'top' || w.config.showNav == 'bottom') {
                var actStepLeft = 0;
                var navStepsWidth = 0;
                $('.sf-nav-step', w.navWrap).not('.sf-nav-step-hidden').each(function(i) {
                    navStepWidth[i] = {};
                    navStepWidth[i].width = $(this).outerWidth(true);
                    navStepWidth[i].index = $(this).data('step');
                    if(navStepWidth[i].index == index) {
                        reindex = i;
                    }
                    if(navStepWidth[i].index == step_active) {
                        restep_active = i;
                    }
                    navStepsWidth += navStepWidth[i].width;
                    if(i < reindex) {
                        actStepLeft += navStepWidth[i].width;
                    }
                })
                if(restep_active - reindex >= 0) { // backward step
                    actStepLeft = actStepLeft - (reindex > 0 ? navStepWidth[reindex - 1].width : 0);
                }
                w.touch.navWidth = false;
                if(navStepsWidth > navWidth) { // nav must be wider than page
                    var navDiffWidth = w.touch.navWidth = navStepsWidth - navWidth;
                    var navNextIndex = (reindex > 0 ? navStepWidth[reindex - 1].index : 0);
                    var navOffset = 0;
                    if(restep_active - reindex <= 0) { // forward step
                        navNextIndex =  (reindex < navStepWidth.length - 1 ? navStepWidth[reindex + 1].index : navStepWidth.length - 1);
                        navOffset = -80;
                    }
                    if(actStepLeft + navOffset > navDiffWidth) { // max left offset
                        actStepLeft = navDiffWidth;
                        navOffset = 0;
                    }
                    var next_step = w.navStep(navNextIndex);
                    $('.sf-nav', w.navWrap).css({transition: 'all ' + w.config.duration + 'ms'})
                    var sign = w.config.rtl ? '' : '-';

                    var prop;
                    var offset = 0;
                    if(next_step.length) {
                        offset = sign + (actStepLeft + navOffset);
                        if(actStepLeft + navOffset < 0) {
                            offset = 0;
                        }
                        prop = 'translateX(' + offset + 'px)';
                    } else {
                        if(navNextIndex < 0) { // first step
                            prop = 'translateX(0px)'
                        } else { // last step
                            offset = sign + (actStepLeft);
                            prop = 'translateX(' + offset + 'px)'
                        }
                    }
                    w.touch.offset = offset;
                    $('.sf-nav', w.navWrap).css({
                        '-webkit-transform': prop,
                        '-moz-transform': prop,
                        '-ms-transform': prop,
                        '-o-transform': prop,
                        'transform': prop
                    });
                }
            } else {
                w.setNavWidth();
            }
        }
    }

    stepFormWizard.prototype.setNavWidth = function() {
        var w = this;
        var maxStepWidth = 0;
        if(w.config.showNav == 'left' || w.config.showNav == 'right') {
            $('.sf-nav-step', w.navWrap).each(function(i) {
                w.navWrap.css('width', '9999px');
                var style = $(this).attr('style');
                var stepWidth = $(this).css({
                    float: 'left',
                    display: 'block',
                    width: 'auto',
                    'white-space': 'nowrap'

                }).outerWidth(true);
                w.navWrap.css('width', '');
                $(this).removeAttr('style').attr('style', style);

                if(maxStepWidth < stepWidth) {
                    maxStepWidth = stepWidth;
                }
            })
            maxStepWidth += 2;
            var contentWidth = w.element.closest('.sf-wizard').width() - maxStepWidth;
            contentWidth--; // because jquery rounding width
            w.element.css({
                width: contentWidth + 'px',
                'float': ''
            });
            if(w.navWrap.hasClass('sf-nav-left')) {
                w.element.css({
                    'margin-left': 'auto',
                    'float': 'left'
                });
            }
            w.navWrap.css('width', maxStepWidth + 'px');
        }

    }

    stepFormWizard.prototype.refresh = function() {
        this.careNav(this.stepActive, this.stepActive);
        this.setProportion(true);
    }

    stepFormWizard.prototype.initBtnNext = function() {
        this.btnNext = this.btnNextTmp
            .clone(true)
            .addClass('sf-btn-next');
        this.btnNext.appendTo($(this.controls));
    }

    stepFormWizard.prototype.initBtnPrev = function() {
        this.btnPrev = this.btnPrevTmp
            .clone(true)
            .addClass('sf-btn-prev');
        this.btnPrev.appendTo($(this.controls));
    }

    stepFormWizard.prototype.initBtnFinish = function() {
        this.btnFinish = this.btnFinishTmp
            .clone(true)
            .addClass('sf-btn-finish');
        this.btnFinish.appendTo($(this.controls));
    }

    stepFormWizard.prototype.next = function(ifFinish, data) {
        return this.goTo('next', data, ifFinish);
    }

    stepFormWizard.prototype.prev = function(data) {
        return this.goTo('prev', data);
    }

    stepFormWizard.prototype.finish = function(data) {
        var w = this;
        var ret = true;
        if(w.config.onFinish(w.stepActive, data) === false) {
            ret = false;
            w.log('Stopped by onFinish');
        }
        var event = jQuery.Event( 'sf-finish' );
        w.element.trigger(event, [w.stepActive, data]);
        if(event.isDefaultPrevented()) {
            ret = false;
            w.log('Stopped by event sf-finish');
        }
        if(ret) {
            w.element.submit();
        }
        return ret;
    }

    stepFormWizard.prototype.log = function(msg) {
        if(this.config.debug === true) {
            console.log(msg);
        }
    }

    $.fn.stepFormWizard = function(options) {
        var sfw = this.data('step-form-wizard');
        if(!sfw) {
            sfw = new stepFormWizard(this.first(), options);
            this.data('step-form-wizard', sfw);
        }
        return sfw;
    };
})(jQuery);