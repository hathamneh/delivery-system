<!-- BEGIN QUICKVIEW SIDEBAR -->
<div id="quickview-sidebar">
    <div class="quickview-header">
        <ul class="nav nav-tabs" id="quickview-tabs-nav" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="chat-tab" data-toggle="tab" href="#chat" role="tab" aria-controls="chat" aria-selected="true">Chat</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notes" role="tab" aria-controls="notes" aria-selected="false">Notes</a></li>
            <li>
                <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
            </li>
        </ul>
    </div>
    <div class="quickview">
        <div class="tab-content">
            <div class="tab-pane active" id="chat" role="tabpanel" aria-labelledby="chat-tab">
                <div class="chat-body current">
                    <div class="chat-search">
                        <form class="form-inverse" action="#" role="search">
                            <div class="append-icon">
                                <input type="text" class="form-control" placeholder="Search contact...">
                                <i class="icon-magnifier"></i>
                            </div>
                        </form>
                    </div>
                    <div class="chat-groups">
                        <div class="title">GROUP CHATS</div>
                        <ul>
                            <li><i class="turquoise"></i> Favorites</li>
                            <li><i class="turquoise"></i> Office Work</li>
                            <li><i class="turquoise"></i> Friends</li>
                        </ul>
                    </div>
                    <div class="chat-list">
                        <div class="title">FAVORITES</div>
                        <ul>
                            <li class="clearfix">
                                <div class="user-img">
                                    <img src="{{ asset('images/avatars/avatar13.png') }}" alt="avatar" />
                                </div>
                                <div class="user-details">
                                    <div class="user-name">Bobby Brown</div>
                                    <div class="user-txt">On the road again...</div>
                                </div>
                                <div class="user-status">
                                    <i class="online"></i>
                                </div>
                            </li>
                            <li class="clearfix">
                                <div class="user-img">
                                    <img src="{{ asset('images/avatars/avatar5.png') }}" alt="avatar'" />
                                    <div class="pull-right badge badge-danger">3</div>
                                </div>
                                <div class="user-details">
                                    <div class="user-name">Alexa Johnson</div>
                                    <div class="user-txt">Still at the beach</div>
                                </div>
                                <div class="user-status">
                                    <i class="away"></i>
                                </div>
                            </li>
                            <li class="clearfix">
                                <div class="user-img">
                                    <img src="{{ asset('images/avatars/avatar10.png') }}" alt="avatar" />
                                </div>
                                <div class="user-details">
                                    <div class="user-name">Bobby Brown</div>
                                    <div class="user-txt">On stage...</div>
                                </div>
                                <div class="user-status">
                                    <i class="busy"></i>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="chat-list">
                        <div class="title">FRIENDS</div>
                        <ul>
                            <li class="clearfix">
                                <div class="user-img">
                                    <img src="{{ asset('images/avatars/avatar7.png') }}" alt="avatar" />
                                    <div class="pull-right badge badge-danger">3</div>
                                </div>
                                <div class="user-details">
                                    <div class="user-name">James Miller</div>
                                    <div class="user-txt">At work...</div>
                                </div>
                                <div class="user-status">
                                    <i class="online"></i>
                                </div>
                            </li>
                            <li class="clearfix">
                                <div class="user-img">
                                    <img src="{{ asset('images/avatars/avatar11.png') }}" alt="avatar" />
                                </div>
                                <div class="user-details">
                                    <div class="user-name">Fred Smith</div>
                                    <div class="user-txt">Waiting for tonight</div>
                                </div>
                                <div class="user-status">
                                    <i class="offline"></i>
                                </div>
                            </li>
                            <li class="clearfix">
                                <div class="user-img">
                                    <img src="{{ asset('images/avatars/avatar8.png') }}" alt="avatar" />
                                </div>
                                <div class="user-details">
                                    <div class="user-name">Ben Addams</div>
                                    <div class="user-txt">On my way to NYC</div>
                                </div>
                                <div class="user-status">
                                    <i class="offline"></i>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="chat-conversation">
                    <div class="conversation-header">
                        <div class="user clearfix">
                            <div class="chat-back">
                                <i class="icon-action-undo"></i>
                            </div>
                            <div class="user-details">
                                <div class="user-name">James Miller</div>
                                <div class="user-txt">On the road again...</div>
                            </div>
                        </div>
                    </div>
                    <div class="conversation-body">
                        <ul>
                            <li class="img">
                                <div class="chat-detail">
                                    <span class="chat-date">today, 10:38pm</span>
                                    <div class="conversation-img">
                                        <img src="{{ asset('images/avatars/avatar4.png') }}" alt="avatar 4"/>
                                    </div>
                                    <div class="chat-bubble">
                                        <span>Hi you!</span>
                                    </div>
                                </div>
                            </li>
                            <li class="img">
                                <div class="chat-detail">
                                    <span class="chat-date">today, 10:45pm</span>
                                    <div class="conversation-img">
                                        <img src="{{ asset('images/avatars/avatar4.png') }}" alt="avatar 4"/>
                                    </div>
                                    <div class="chat-bubble">
                                        <span>Are you there?</span>
                                    </div>
                                </div>
                            </li>
                            <li class="img">
                                <div class="chat-detail">
                                    <span class="chat-date">today, 10:51pm</span>
                                    <div class="conversation-img">
                                        <img src="{{ asset('images/avatars/avatar4.png') }}" alt="avatar 4"/>
                                    </div>
                                    <div class="chat-bubble">
                                        <span>Send me a message when you come back.</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="conversation-message">
                        <input type="text" placeholder="Your message..." class="form-control form-white send-message" />
                        <div class="item-footer clearfix">
                            <div class="footer-actions">
                                <i class="icon-rounded-marker"></i>
                                <i class="icon-rounded-camera"></i>
                                <i class="icon-rounded-paperclip-oblique"></i>
                                <i class="icon-rounded-alarm-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                <div class="list-notes current withScroll">
                    <div class="notes ">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="add-note">
                                    <i class="fa fa-plus"></i>ADD A NEW NOTE
                                </div>
                            </div>
                        </div>
                        <div id="notes-list">
                            <div class="note-item media current fade in">
                                <button class="close">×</button>
                                <div>
                                    <div>
                                        <p class="note-name">Reset my account password</p>
                                    </div>
                                    <p class="note-desc hidden">Break security reasons.</p>
                                    <p><small>Tuesday 6 May, 3:52 pm</small></p>
                                </div>
                            </div>
                            <div class="note-item media fade in">
                                <button class="close">×</button>
                                <div>
                                    <div>
                                        <p class="note-name">Call John</p>
                                    </div>
                                    <p class="note-desc hidden">He have my laptop!</p>
                                    <p><small>Thursday 8 May, 2:28 pm</small></p>
                                </div>
                            </div>
                            <div class="note-item media fade in">
                                <button class="close">×</button>
                                <div>
                                    <div>
                                        <p class="note-name">Buy a car</p>
                                    </div>
                                    <p class="note-desc hidden">I'm done with the bus</p>
                                    <p><small>Monday 12 May, 3:43 am</small></p>
                                </div>
                            </div>
                            <div class="note-item media fade in">
                                <button class="close">×</button>
                                <div>
                                    <div>
                                        <p class="note-name">Don't forget my notes</p>
                                    </div>
                                    <p class="note-desc hidden">I have to read them...</p>
                                    <p><small>Wednesday 5 May, 6:15 pm</small></p>
                                </div>
                            </div>
                            <div class="note-item media current fade in">
                                <button class="close">×</button>
                                <div>
                                    <div>
                                        <p class="note-name">Reset my account password</p>
                                    </div>
                                    <p class="note-desc hidden">Break security reasons.</p>
                                    <p><small>Tuesday 6 May, 3:52 pm</small></p>
                                </div>
                            </div>
                            <div class="note-item media fade in">
                                <button class="close">×</button>
                                <div>
                                    <div>
                                        <p class="note-name">Call John</p>
                                    </div>
                                    <p class="note-desc hidden">He have my laptop!</p>
                                    <p><small>Thursday 8 May, 2:28 pm</small></p>
                                </div>
                            </div>
                            <div class="note-item media fade in">
                                <button class="close">×</button>
                                <div>
                                    <div>
                                        <p class="note-name">Buy a car</p>
                                    </div>
                                    <p class="note-desc hidden">I'm done with the bus</p>
                                    <p><small>Monday 12 May, 3:43 am</small></p>
                                </div>
                            </div>
                            <div class="note-item media fade in">
                                <button class="close">×</button>
                                <div>
                                    <div>
                                        <p class="note-name">Don't forget my notes</p>
                                    </div>
                                    <p class="note-desc hidden">I have to read them...</p>
                                    <p><small>Wednesday 5 May, 6:15 pm</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-note note-hidden-sm">
                    <div class="note-header clearfix">
                        <div class="note-back">
                            <i class="icon-action-undo"></i>
                        </div>
                        <div class="note-edit">Edit Note</div>
                        <div class="note-subtitle">title on first line</div>
                    </div>
                    <div id="note-detail">
                        <div class="note-write">
                            <textarea class="form-control" placeholder="Type your note here"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <div class="settings">
                    <div class="title">ACCOUNT SETTINGS</div>
                    <div class="setting">
                        <span> Show Personal Statut</span>
                        <label class="switch pull-right">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                        </label>
                        <p class="setting-info">Lorem ipsum dolor sit amet consectetuer.</p>
                    </div>
                    <div class="setting">
                        <span> Show my Picture</span>
                        <label class="switch pull-right">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                        </label>
                        <p class="setting-info">Lorem ipsum dolor sit amet consectetuer.</p>
                    </div>
                    <div class="setting">
                        <span> Show my Location</span>
                        <label class="switch pull-right">
                            <input type="checkbox" class="switch-input">
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                        </label>
                        <p class="setting-info">Lorem ipsum dolor sit amet consectetuer.</p>
                    </div>
                    <div class="title">CHAT</div>
                    <div class="setting">
                        <span> Show User Image</span>
                        <label class="switch pull-right">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                        </label>
                    </div>
                    <div class="setting">
                        <span> Show Fullname</span>
                        <label class="switch pull-right">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                        </label>
                    </div>
                    <div class="setting">
                        <span> Show Location</span>
                        <label class="switch pull-right">
                            <input type="checkbox" class="switch-input">
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                        </label>
                    </div>
                    <div class="setting">
                        <span> Show Unread Count</span>
                        <label class="switch pull-right">
                            <input type="checkbox" class="switch-input" checked>
                            <span class="switch-label" data-on="On" data-off="Off"></span>
                            <span class="switch-handle"></span>
                        </label>
                    </div>
                    <div class="title">STATISTICS</div>
                    <div class="settings-chart">
                        <div class="progress visible">
                            <progress class="progress-bar-primary stat1" value="82" max="100"></progress>
                            <div class="progress-info">
                                <span class="progress-name">Stat 1</span>
                                <span class="progress-value">82%</span>
                            </div>
                        </div>
                    </div>
                    <div class="settings-chart">
                        <div class="progress visible">
                            <progress class="progress-bar-primary stat1" value="43" max="100"></progress>
                            <div class="progress-info">
                                <span class="progress-name">Stat 2</span>
                                <span class="progress-value">43%</span>
                            </div>
                        </div>
                    </div>
                    <div class="m-t-30" style="width:100%">
                        <canvas id="setting-chart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END QUICKVIEW SIDEBAR -->
