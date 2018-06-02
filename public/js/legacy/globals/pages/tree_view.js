$(function () {



    /* Simple tree with colored icons  */
    $('#tree1').jstree({
        'core': {
            'data': [{
                'text': 'My pictures',
                "icon": "fa fa-picture-o c-red",
                'state': {
                    'selected': false
                }
            }, {
                'text': 'My videos',
                "icon": "fa fa-film c-orange",
                'state': {
                    'opened': true,
                    'selected': false
                },
                'children': [{
                    'text': 'Video 1',
                    "icon": "fa fa-film c-orange"
                }, {
                    'text': 'Video 2',
                    "icon": "fa fa-film c-orange"
                }]
            }, {
                'text': 'My documents',
                "icon": "fa fa-folder-o c-purple",
                'state': {
                    'selected': false
                },
                'children': [{
                    'text': 'Document 1',
                    "icon": "fa fa-folder-o c-purple",
                }, {
                    'text': 'Document 2',
                    "icon": "fa fa-folder-o c-purple",
                }]
            }, {
                'text': 'Events',
                "icon": "fa fa-calendar c-green",
                'state': {
                    'opened': false,
                    'selected': false
                }
            }, {
                'text': 'Messages',
                "icon": "fa fa-envelope-o",
                'state': {
                    'opened': false,
                    'selected': false
                }
            }, ]
        }
    });

    /*  Tree with checkbox option  */
    $('#tree2').jstree({
        'core': {
            'data': [{
                'text': 'My pictures',
                "icon": "fa fa-picture-o",
                'state': {
                    'selected': false
                }
            }, {
                'text': 'My videos',
                "icon": "fa fa-film",
                'state': {
                    'opened': true,
                    'selected': false
                },
                'children': [{
                    'text': 'Video 1',
                    "icon": "fa fa-film"
                }, {
                    'text': 'Video 2',
                    "icon": "fa fa-film"
                }]
            }, {
                'text': 'My documents',
                "icon": "fa fa-folder-o",
                'state': {
                    'selected': false
                },
                'children': [{
                    'text': 'Document 1',
                    "icon": "fa fa-folder-o",
                }, {
                    'text': 'Document 2',
                    "icon": "fa fa-folder-o",
                }]
            }, {
                'text': 'Events',
                "icon": "fa fa-calendar",
                'state': {
                    'opened': false,
                    'selected': false
                }
            }, {
                'text': 'Messages',
                "icon": "fa fa-envelope-o",
                'state': {
                    'opened': false,
                    'selected': false
                }
            }, ]
        },
        "plugins": ["checkbox"],
    });

    /*  Tree with drag & drop  */
    $('#tree3').jstree({
        'core': {
            "check_callback": true,
            'data': [{
                    'text': 'My pictures',
                    "icon": "fa fa-picture-o c-primary",
                    'state': {
                        'selected': false
                    }
                }, {
                    'text': 'My videos',
                    "icon": "fa fa-film c-primary",
                    'state': {
                        'opened': true,
                        'selected': false
                    },
                    'children': [{
                        'text': 'Video 1',
                        "icon": "fa fa-film c-primary"
                    }, {
                        'text': 'Video 2',
                        "icon": "fa fa-film c-primary"
                    }]
                }, {
                    'text': 'My documents',
                    "icon": "fa fa-folder-o c-primary",
                    'state': {
                        'selected': false
                    },
                    'children': [{
                        'text': 'Document 1',
                        "icon": "fa fa-folder-o c-primary",
                    }, {
                        'text': 'Document 2',
                        "icon": "fa fa-folder-o c-primary",
                    }]
                }, {
                    'text': 'Events',
                    "icon": "fa fa-calendar c-primary",
                    'state': {
                        'opened': false,
                        'selected': false
                    }
                }, {
                    'text': 'Messages',
                    "icon": "fa fa-envelope-o c-primary",
                    'state': {
                        'opened': false,
                        'selected': false
                    }
                },

            ]
        },
        "plugins": ["dnd"]
    });


});