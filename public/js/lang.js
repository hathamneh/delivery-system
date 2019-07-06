/*!
 *  Lang.js for Laravel localization in JavaScript.
 *
 *  @version 1.1.10
 *  @license MIT https://github.com/rmariuzzo/Lang.js/blob/master/LICENSE
 *  @site    https://github.com/rmariuzzo/Lang.js
 *  @author  Rubens Mariuzzo <rubens@mariuzzo.com>
 */
(function(root,factory){"use strict";if(typeof define==="function"&&define.amd){define([],factory)}else if(typeof exports==="object"){module.exports=factory()}else{root.Lang=factory()}})(this,function(){"use strict";function inferLocale(){if(typeof document!=="undefined"&&document.documentElement){return document.documentElement.lang}}function convertNumber(str){if(str==="-Inf"){return-Infinity}else if(str==="+Inf"||str==="Inf"||str==="*"){return Infinity}return parseInt(str,10)}var intervalRegexp=/^({\s*(\-?\d+(\.\d+)?[\s*,\s*\-?\d+(\.\d+)?]*)\s*})|([\[\]])\s*(-Inf|\*|\-?\d+(\.\d+)?)\s*,\s*(\+?Inf|\*|\-?\d+(\.\d+)?)\s*([\[\]])$/;var anyIntervalRegexp=/({\s*(\-?\d+(\.\d+)?[\s*,\s*\-?\d+(\.\d+)?]*)\s*})|([\[\]])\s*(-Inf|\*|\-?\d+(\.\d+)?)\s*,\s*(\+?Inf|\*|\-?\d+(\.\d+)?)\s*([\[\]])/;var defaults={locale:"en"};var Lang=function(options){options=options||{};this.locale=options.locale||inferLocale()||defaults.locale;this.fallback=options.fallback;this.messages=options.messages};Lang.prototype.setMessages=function(messages){this.messages=messages};Lang.prototype.getLocale=function(){return this.locale||this.fallback};Lang.prototype.setLocale=function(locale){this.locale=locale};Lang.prototype.getFallback=function(){return this.fallback};Lang.prototype.setFallback=function(fallback){this.fallback=fallback};Lang.prototype.has=function(key,locale){if(typeof key!=="string"||!this.messages){return false}return this._getMessage(key,locale)!==null};Lang.prototype.get=function(key,replacements,locale){if(!this.has(key,locale)){return key}var message=this._getMessage(key,locale);if(message===null){return key}if(replacements){message=this._applyReplacements(message,replacements)}return message};Lang.prototype.trans=function(key,replacements){return this.get(key,replacements)};Lang.prototype.choice=function(key,number,replacements,locale){replacements=typeof replacements!=="undefined"?replacements:{};replacements.count=number;var message=this.get(key,replacements,locale);if(message===null||message===undefined){return message}var messageParts=message.split("|");var explicitRules=[];for(var i=0;i<messageParts.length;i++){messageParts[i]=messageParts[i].trim();if(anyIntervalRegexp.test(messageParts[i])){var messageSpaceSplit=messageParts[i].split(/\s/);explicitRules.push(messageSpaceSplit.shift());messageParts[i]=messageSpaceSplit.join(" ")}}if(messageParts.length===1){return message}for(var j=0;j<explicitRules.length;j++){if(this._testInterval(number,explicitRules[j])){return messageParts[j]}}var pluralForm=this._getPluralForm(number);return messageParts[pluralForm]};Lang.prototype.transChoice=function(key,count,replacements){return this.choice(key,count,replacements)};Lang.prototype._parseKey=function(key,locale){if(typeof key!=="string"||typeof locale!=="string"){return null}var segments=key.split(".");var source=segments[0].replace(/\//g,".");return{source:locale+"."+source,sourceFallback:this.getFallback()+"."+source,entries:segments.slice(1)}};Lang.prototype._getMessage=function(key,locale){locale=locale||this.getLocale();key=this._parseKey(key,locale);if(this.messages[key.source]===undefined&&this.messages[key.sourceFallback]===undefined){return null}var message=this.messages[key.source];var entries=key.entries.slice();var subKey="";while(entries.length&&message!==undefined){var subKey=!subKey?entries.shift():subKey.concat(".",entries.shift());if(message[subKey]!==undefined){message=message[subKey];subKey=""}}if(typeof message!=="string"&&this.messages[key.sourceFallback]){message=this.messages[key.sourceFallback];entries=key.entries.slice();subKey="";while(entries.length&&message!==undefined){var subKey=!subKey?entries.shift():subKey.concat(".",entries.shift());if(message[subKey]){message=message[subKey];subKey=""}}}if(typeof message!=="string"){return null}return message};Lang.prototype._findMessageInTree=function(pathSegments,tree){while(pathSegments.length&&tree!==undefined){var dottedKey=pathSegments.join(".");if(tree[dottedKey]){tree=tree[dottedKey];break}tree=tree[pathSegments.shift()]}return tree};Lang.prototype._applyReplacements=function(message,replacements){for(var replace in replacements){message=message.replace(new RegExp(":"+replace,"gi"),function(match){var value=replacements[replace];var allCaps=match===match.toUpperCase();if(allCaps){return value.toUpperCase()}var firstCap=match===match.replace(/\w/i,function(letter){return letter.toUpperCase()});if(firstCap){return value.charAt(0).toUpperCase()+value.slice(1)}return value})}return message};Lang.prototype._testInterval=function(count,interval){if(typeof interval!=="string"){throw"Invalid interval: should be a string."}interval=interval.trim();var matches=interval.match(intervalRegexp);if(!matches){throw"Invalid interval: "+interval}if(matches[2]){var items=matches[2].split(",");for(var i=0;i<items.length;i++){if(parseInt(items[i],10)===count){return true}}}else{matches=matches.filter(function(match){return!!match});var leftDelimiter=matches[1];var leftNumber=convertNumber(matches[2]);if(leftNumber===Infinity){leftNumber=-Infinity}var rightNumber=convertNumber(matches[3]);var rightDelimiter=matches[4];return(leftDelimiter==="["?count>=leftNumber:count>leftNumber)&&(rightDelimiter==="]"?count<=rightNumber:count<rightNumber)}return false};Lang.prototype._getPluralForm=function(count){switch(this.locale){case"az":case"bo":case"dz":case"id":case"ja":case"jv":case"ka":case"km":case"kn":case"ko":case"ms":case"th":case"tr":case"vi":case"zh":return 0;case"af":case"bn":case"bg":case"ca":case"da":case"de":case"el":case"en":case"eo":case"es":case"et":case"eu":case"fa":case"fi":case"fo":case"fur":case"fy":case"gl":case"gu":case"ha":case"he":case"hu":case"is":case"it":case"ku":case"lb":case"ml":case"mn":case"mr":case"nah":case"nb":case"ne":case"nl":case"nn":case"no":case"om":case"or":case"pa":case"pap":case"ps":case"pt":case"so":case"sq":case"sv":case"sw":case"ta":case"te":case"tk":case"ur":case"zu":return count==1?0:1;case"am":case"bh":case"fil":case"fr":case"gun":case"hi":case"hy":case"ln":case"mg":case"nso":case"xbr":case"ti":case"wa":return count===0||count===1?0:1;case"be":case"bs":case"hr":case"ru":case"sr":case"uk":return count%10==1&&count%100!=11?0:count%10>=2&&count%10<=4&&(count%100<10||count%100>=20)?1:2;case"cs":case"sk":return count==1?0:count>=2&&count<=4?1:2;case"ga":return count==1?0:count==2?1:2;case"lt":return count%10==1&&count%100!=11?0:count%10>=2&&(count%100<10||count%100>=20)?1:2;case"sl":return count%100==1?0:count%100==2?1:count%100==3||count%100==4?2:3;case"mk":return count%10==1?0:1;case"mt":return count==1?0:count===0||count%100>1&&count%100<11?1:count%100>10&&count%100<20?2:3;case"lv":return count===0?0:count%10==1&&count%100!=11?1:2;case"pl":return count==1?0:count%10>=2&&count%10<=4&&(count%100<12||count%100>14)?1:2;case"cy":return count==1?0:count==2?1:count==8||count==11?2:3;case"ro":return count==1?0:count===0||count%100>0&&count%100<20?1:2;case"ar":return count===0?0:count==1?1:count==2?2:count%100>=3&&count%100<=10?3:count%100>=11&&count%100<=99?4:5;default:return 0}};return Lang});(function(){Lang=new Lang();Lang.setMessages({"ar.auth":{"failed":"These credentials do not match our records.","logout":"Logout","password":"Password","throttle":"Too many login attempts. Please try again in :seconds seconds.","username":"Username"},"ar.base":{"arabic":"\u0627\u0644\u0639\u0631\u0628\u064a\u0629","cancel":"Cancel","dir":"rtl","english":"English","footer_copyright":"Copyright \u00a9 2018 Kangaroo Delivery System. All rights reserved.","for":"for","home":"Home","name":"\u0627\u0644\u0639\u0631\u0628\u064a\u0629","recaptcha_policy_statement":"This website uses reCAPTCHA by & under Google's terms"},"ar.client":{"all":"All Clients","label":"Clients","single":"Client"},"ar.courier":{"all":"All Couriers","label":"Couriers","single":"Courier"},"ar.dashboard":{"stats":{"clients":"Clients","couriers":"Couriers","delivered":"Delivered","label":"Statistics","pending":"Pending","pickups":"Pickups","received":"Received"}},"ar.mailing":{"label":"Mailing"},"ar.note":{"all":"All Notes","label":"Notes","private_notes":"Private Notes","public_notes":"Public Notes","single":"Note"},"ar.pagination":{"next":"Next &raquo;","previous":"&laquo; Previous"},"ar.passwords":{"password":"Passwords must be at least six characters and match the confirmation.","reset":"Your password has been reset!","sent":"We have e-mailed your password reset link!","token":"This password reset token is invalid.","user":"We can't find a user with that e-mail address."},"ar.pickup":{"all":"All Pickups","label":"Pickups","single":"Pickup","today_pickups":"Today's Pickups"},"ar.service":{"all":"All Services","label":"Services","single":"Service"},"ar.shipment":{"all":"All Shipments","client":{"city":"Client City","country":"Client Country","name":"Client Name","phone":"Client Phone Number"},"client_account_number":"Client Account Number","client_info":"Client Info","client_placeholder":"Find client by account number","courier":{"help":"Select the responsible courier for delivering this shipment.","label":"Courier"},"delivery_cost_lodger":{"client":"Client","courier":"Courier","help":"Who's responsible for collecting money?","label":"Delivery Cost Lodger"},"delivery_date":"Delivery Date","delivery_details":"Delivery Details","details":"Shipment Details","detailsNote":"Please fill shipment details carefully:","enter_identifier":"Please Enter Shipment Waybill Number","existing_client":"Existing Client","external_client":"Not-registered Client","external_notes":"Notes from Courier","internal_notes":"Notes for Courier","label":"Shipments","new":"New Shipment","package_weight":"Package Weight","review":"Review Shipment","reviewNote":"Review the data you have entered for this shipment before submitting","service_type":{"help":"When this shipment should be deliverd?","label":"Service Type","nextday":"Next Day Delivery","sameday":"Same Day Delivery"},"shipment_value":"Shipment Value","single":"Shipment","status":"Status","statuses":{"attempted_delivery":"Attempted Delivery","cancelled":"Cancelled","delivered":"Delivered","failed":"delivery_failed","picked_up":"Picked Up","received":"Received","rejected":"Rejected","returned":"Returned"},"track_shipment":"Track Your Shipment","waybill":"Waybill number"},"ar.sidebar":{"add_new":"Add New","dashboard":"Dashboard","logs":"Logs","manage":"Management","settings":"Settings"},"ar.topbar":{"welcome":"Welcome, :name"},"ar.user":{"all":"All Users","label":"Users","single":"User"},"ar.validation":{"accepted":"The :attribute must be accepted.","active_url":"The :attribute is not a valid URL.","after":"The :attribute must be a date after :date.","after_or_equal":"The :attribute must be a date after or equal to :date.","alpha":"The :attribute may only contain letters.","alpha_dash":"The :attribute may only contain letters, numbers, and dashes.","alpha_num":"The :attribute may only contain letters and numbers.","array":"The :attribute must be an array.","attributes":[],"before":"The :attribute must be a date before :date.","before_or_equal":"The :attribute must be a date before or equal to :date.","between":{"array":"The :attribute must have between :min and :max items.","file":"The :attribute must be between :min and :max kilobytes.","numeric":"The :attribute must be between :min and :max.","string":"The :attribute must be between :min and :max characters."},"boolean":"The :attribute field must be true or false.","confirmed":"The :attribute confirmation does not match.","custom":{"attribute-name":{"rule-name":"custom-message"}},"date":"The :attribute is not a valid date.","date_format":"The :attribute does not match the format :format.","different":"The :attribute and :other must be different.","digits":"The :attribute must be :digits digits.","digits_between":"The :attribute must be between :min and :max digits.","dimensions":"The :attribute has invalid image dimensions.","distinct":"The :attribute field has a duplicate value.","email":"The :attribute must be a valid email address.","exists":"The selected :attribute is invalid.","file":"The :attribute must be a file.","filled":"The :attribute field must have a value.","gt":{"array":"The :attribute must have more than :value items.","file":"The :attribute must be greater than :value kilobytes.","numeric":"The :attribute must be greater than :value.","string":"The :attribute must be greater than :value characters."},"gte":{"array":"The :attribute must have :value items or more.","file":"The :attribute must be greater than or equal :value kilobytes.","numeric":"The :attribute must be greater than or equal :value.","string":"The :attribute must be greater than or equal :value characters."},"image":"The :attribute must be an image.","in":"The selected :attribute is invalid.","in_array":"The :attribute field does not exist in :other.","integer":"The :attribute must be an integer.","ip":"The :attribute must be a valid IP address.","ipv4":"The :attribute must be a valid IPv4 address.","ipv6":"The :attribute must be a valid IPv6 address.","json":"The :attribute must be a valid JSON string.","lt":{"array":"The :attribute must have less than :value items.","file":"The :attribute must be less than :value kilobytes.","numeric":"The :attribute must be less than :value.","string":"The :attribute must be less than :value characters."},"lte":{"array":"The :attribute must not have more than :value items.","file":"The :attribute must be less than or equal :value kilobytes.","numeric":"The :attribute must be less than or equal :value.","string":"The :attribute must be less than or equal :value characters."},"max":{"array":"The :attribute may not have more than :max items.","file":"The :attribute may not be greater than :max kilobytes.","numeric":"The :attribute may not be greater than :max.","string":"The :attribute may not be greater than :max characters."},"mimes":"The :attribute must be a file of type: :values.","mimetypes":"The :attribute must be a file of type: :values.","min":{"array":"The :attribute must have at least :min items.","file":"The :attribute must be at least :min kilobytes.","numeric":"The :attribute must be at least :min.","string":"The :attribute must be at least :min characters."},"not_in":"The selected :attribute is invalid.","not_regex":"The :attribute format is invalid.","numeric":"The :attribute must be a number.","present":"The :attribute field must be present.","regex":"The :attribute format is invalid.","required":"The :attribute field is required.","required_if":"The :attribute field is required when :other is :value.","required_unless":"The :attribute field is required unless :other is in :values.","required_with":"The :attribute field is required when :values is present.","required_with_all":"The :attribute field is required when :values is present.","required_without":"The :attribute field is required when :values is not present.","required_without_all":"The :attribute field is required when none of :values are present.","same":"The :attribute and :other must match.","size":{"array":"The :attribute must contain :size items.","file":"The :attribute must be :size kilobytes.","numeric":"The :attribute must be :size.","string":"The :attribute must be :size characters."},"string":"The :attribute must be a string.","timezone":"The :attribute must be a valid zone.","unique":"The :attribute has already been taken.","uploaded":"The :attribute failed to upload.","url":"The :attribute format is invalid."},"ar.zone":{"address":{"delete":"Delete Address","edit":"Edit Address","name":"Address Name","new":"New Address","sameday_price":"Same Day Price","save":"Save Address","scheduled_price":"Next Day Price"},"addresses":"Zone Addresses","all":"All Zones","charge_per_unit":"Charge Per Unit (KG)","edit":"Edit Zone","extra_fees_per_unit":"Extra Fees Per Charge Unit","label":"Zones","name":"Zone Name","new":"New Zone","no_addresses":"This zone does not have addresses yet!","save":"Save","single":"Zone","standard_weight":"Standard Weight (KG)"},"en.accounting":{"due_for":"Due For","due_from":"Due From","label":"Accounting"},"en.auth":{"failed":"These credentials do not match our records.","logout":"Logout","password":"Password","show_password":"Show Password","throttle":"Too many login attempts. Please try again in :seconds seconds.","type":"Account Type","username":"Username"},"en.client":{"account_number":"Account Number","address":"Client Address","address_maps":"Address on Google Maps","address_sub":"Sub-Address","all":"All Clients","bank":{"account_number":"Bank Account Number","holder_name":"Account Holder Name","iban":"IBAN","info":"Bank Information","name":"Bank Name"},"c_account_number":"Client Account Number","category":"Category","charged_for":{"cancelled":"Charged for cancelled shipments","fixed_value":"Fixed Value","percentage_value":"Percentage Value","rejected":"Charged for rejected shipments","value":"Value to charge per shipment"},"city":"City","country":"Country","create":"New Client","email":"Email","files":"Client Attachments","go_to_dashboard":"Go to :client Dashboard","label":"Clients","local_store":"Local Store","maps_placeholder":"http:\/\/maps.google.com\/...","name":"Client Name","online_store":"Online Store","phone":"Phone","pickup_address_maps":"Pickup Address on Google Maps","pickup_address_text":"Pickup Address","save":"Save Client","sector":"Sector","shipment":"Shipment","single":"Client","statistics":"Statistics","trade_name":"Trade Name","urls":{"facebook":"Facebook Account","instagram":"Instagram Account","website":"Client Website"},"zone":"Client Zone"},"en.common":{"actions":"Actions","apply":"Apply","arabic":"\u0627\u0644\u0639\u0631\u0628\u064a\u0629","cancel":"Cancel","customRange":"Custom Range","dir":"ltr","english":"English","footer_copyright":"Copyright \u00a9 2018 Kangaroo Delivery System. All rights reserved.","for":"for","home":"Home","jod":"JOD","last30days":"Last 30 days","last7days":"Last 7 days","lastMonth":"Last Month","lifetime":"Lifetime","name":"English","new":"New","recaptcha_policy_statement":"This website uses reCAPTCHA by & under Google's terms","save":"Save","save_changes":"Save Changes","select":"-- Select --","selectAll":"Select All","thisMonth":"This Month","today":"Today","yesterday":"Yesterday"},"en.courier":{"address":"Courier Address","all":"All Couriers","category":"Courier Category","create":"New Courier","created":"<i class=\"fa-check-circle2\"><\/i> Courier created successfully!","delete":"Delete Courier","edit":"Edit Courier","email":"Email","employee":"Employee","files":"Courier Attachments","freelance":"Freelance","id":"ID","label":"Couriers","name":"Courier Name","notes":"Notes","password":"Password","phone":"Phone Number","save":"Save Courier","single":"Courier","username":"Username","zone":"Courier Zone"},"en.dashboard":{"stats":{"clients":"Clients","couriers":"Couriers","delivered":"Delivered","label":"Statistics","pending":"Pending","pickups":"Pickups","received":"Received"}},"en.mailing":{"label":"Mailing"},"en.note":{"all":"All Notes","label":"Notes","private_notes":"Private Notes","public_notes":"Public Notes","single":"Note"},"en.pagination":{"next":"Next &raquo;","previous":"&laquo; Previous"},"en.passwords":{"password":"Passwords must be at least six characters and match the confirmation.","reset":"Your password has been reset!","sent":"We have e-mailed your password reset link!","token":"This password reset token is invalid.","user":"We can't find a user with that e-mail address."},"en.pickup":{"actual":"Actual","actual_packages_number":"Actual Packages Number","address_maps":"Address (Google Maps Link)","address_text":"Address (Text)","all":"All Pickups","available_time":"Available Time","client_account_number":"Client Account Number","client_phone":"Client Phone","completed":"Completed","courier":"Courier to Pickup","create":"New Pickup","customer_phone":"Customer Phone","declined":"Declined","delete":"Delete Pickup","edit":"Edit Pickup","expected":"Expected","expected_packages_number":"Expected Packages Number","from_client":"Client","from_client_description":"Pick up from the client himself.","from_customer":"Customer","from_customer_description":"Pick up from one of client customers.","history":"Pickup History","identifier":"Identifier","label":"Pickups","not_picked_up_yet":"Not Picked Up Yet!","notes":"Your notes","pending":"Pending","phone":"Phone Number","pickup_fees":"Extra Fees","pickup_from":"Pick up From","save":"Save Pickup","show_more":"Pickup Details","single":"Pickup","today_pickups":"Today's Pickups","waybills":"Related Shipments (Waybills)"},"en.reports":{"label":"Reports","select_client":"Filter By Client","select_courier":"Filter By Courier","with_selected":"With Selected:"},"en.service":{"all":"All Services","label":"Services","single":"Service"},"en.settings":{"label":"Settings","notice":"Be careful! These settings will change global system behavior."},"en.shipment":{"actions":"Shipment Actions","actual_paid":"Paid By Consignee","address":"Select Address","address_maps_link":"Google Maps Link","address_sub_text":"Detailed Address","all":"All Shipments","change_original_status":"What happened with this shipment?","change_status":"Change Status","client":{"city":"City","country":"Country","name":"Name","phone":"Phone Number","type":"Type"},"client_account_number":"Client Account Number","client_info":"Client Info","client_paid":"Client Paid","client_placeholder":"Find client by account number","consignee_name":"Consignee Name","courier":"Courier","courier_cashed":"Courier Cashed","couriers":{"help":"Select the courier responsible for delivering this shipment.","label":"Courier"},"custom_price":"Override delivery cost","custom_price_help":"Use this value for delivery cost instead of computing it selected address","delete":"Delete Shipment","delete_notice":"When you delete the shipment all its data will be deleted and you will never be able to get them back.<br><b class='text-danger'>Please be certain!<\/b>","delivery_cost":"Delivery Cost","delivery_cost_lodger":{"client":"Client","courier":"Courier","help":"Who's responsible for collecting money?","label":"Delivery Cost Lodger"},"delivery_date":"Delivery Date","delivery_details":"Delivery Details","details":"Shipment Details","detailsNote":"Please fill shipment details carefully:","edit":"Edit Shipment","enter_identifier":"Please Enter Shipment Waybill Number","existing_client":"Existing Client","external_client":"Not-registered Client","external_notes":"Notes from Courier","extra_services":"Extra Services","fees":"Fees","info":"Shipment Info","initial_status":"Initial Status","internal_notes":"Notes for Courier","label":"Shipments","log":"Shipment Lifecycle","make_returned":"Return this Shipment","new":"New Shipment","package_weight":"Package Weight","phone_number":"Phone Number","price_of_address":"Price Of Address","return":"Return Shipment","return_notice":"If this shipment is <b>rejected<\/b> or <b>cancelled<\/b> and you want to return it to the client, please click <b>Return this Shipment<\/b> to create another new shipment of type returned. This will help you in tracking.","returned":"Returned Shipments","returnedDeliveryDate":"When the returned shipment will be delivered?","review":"Review Shipment","reviewNote":"Review the data you have entered for this shipment before submitting","select_multi_service":"You can select multiple services...","service_type":"Service Type","service_types":{"help":"When this shipment should be deliverd?","label":"Service Type","nextday":"Next Day Delivery","sameday":"Same Day Delivery"},"services_cost":"Services Cost","shipment_value":"Shipment Value","shipments":"{0} No shipments assigned|{1} One shipment assigned|[2,*] :value shipments assigned","single":"Shipment","status":"Status","status_notes":"Reasons for this status","statuses":{"cancelled":"Cancelled","consignee_rescheduled":"Consignee Rescheduled","delivered":"Delivered","failed":"Failed","not_available":"Not Available","on_hold":"On Hold","out_for_delivery":"Out for delivery","picked_up":"Picked Up","received":"Received","rejected":"Rejected","returned":"Returned"},"sub_status":"Sub Status","summery":"Shipment Summery","total":"Total","total_price":"Total Delivery Price","track_shipment":"Track Your Shipment","updated":"{0} Nothing updated|{1} <i class='fa-check-circle2'><\/i> One shipment updated successfully.|[2,*] <i class='fa-check-circle2'><\/i> :value shipments updated successfully.","waybill":"Waybill number"},"en.sidebar":{"add_new":"Add New","dashboard":"Dashboard","extra":"Extra","logs":"Logs","manage":"Management","reporting":"Reporting","settings":"Settings","users_roles":"Users & Roles"},"en.topbar":{"welcome":"Welcome, :name"},"en.user":{"_save":{"email":"Save Email","password":"Save Password","template":"Save Role","username":"Save Username"},"add_new":"Add New User","all":"All Users","edit":"Edit User","email":"Email","label":"Users","new":"New User","password":"Password","password_confirmation":"Confirm","roles":{"add_new":"Add New Role","create":"Create","delete":"Delete","description":"Role Description","edit":"Edit Role","label":"Roles","name":"Role Name","no_access":"No Access","permissions":"Role Permissions","select":"Select User Role","update":"Update","view":"View"},"save":"Save User","single":"User","template":"User Role","username":"Username"},"en.validation":{"accepted":"The :attribute must be accepted.","active_url":"The :attribute is not a valid URL.","after":"The :attribute must be a date after :date.","after_or_equal":"The :attribute must be a date after or equal to :date.","alpha":"The :attribute may only contain letters.","alpha_dash":"The :attribute may only contain letters, numbers, and dashes.","alpha_num":"The :attribute may only contain letters and numbers.","array":"The :attribute must be an array.","attributes":[],"before":"The :attribute must be a date before :date.","before_or_equal":"The :attribute must be a date before or equal to :date.","between":{"array":"The :attribute must have between :min and :max items.","file":"The :attribute must be between :min and :max kilobytes.","numeric":"The :attribute must be between :min and :max.","string":"The :attribute must be between :min and :max characters."},"boolean":"The :attribute field must be true or false.","confirmed":"The :attribute confirmation does not match.","custom":{"attribute-name":{"rule-name":"custom-message"}},"date":"The :attribute is not a valid date.","date_format":"The :attribute does not match the format :format.","different":"The :attribute and :other must be different.","digits":"The :attribute must be :digits digits.","digits_between":"The :attribute must be between :min and :max digits.","dimensions":"The :attribute has invalid image dimensions.","distinct":"The :attribute field has a duplicate value.","email":"The :attribute must be a valid email address.","exists":"The selected :attribute is invalid.","file":"The :attribute must be a file.","filled":"The :attribute field must have a value.","gt":{"array":"The :attribute must have more than :value items.","file":"The :attribute must be greater than :value kilobytes.","numeric":"The :attribute must be greater than :value.","string":"The :attribute must be greater than :value characters."},"gte":{"array":"The :attribute must have :value items or more.","file":"The :attribute must be greater than or equal :value kilobytes.","numeric":"The :attribute must be greater than or equal :value.","string":"The :attribute must be greater than or equal :value characters."},"image":"The :attribute must be an image.","in":"The selected :attribute is invalid.","in_array":"The :attribute field does not exist in :other.","integer":"The :attribute must be an integer.","ip":"The :attribute must be a valid IP address.","ipv4":"The :attribute must be a valid IPv4 address.","ipv6":"The :attribute must be a valid IPv6 address.","json":"The :attribute must be a valid JSON string.","lt":{"array":"The :attribute must have less than :value items.","file":"The :attribute must be less than :value kilobytes.","numeric":"The :attribute must be less than :value.","string":"The :attribute must be less than :value characters."},"lte":{"array":"The :attribute must not have more than :value items.","file":"The :attribute must be less than or equal :value kilobytes.","numeric":"The :attribute must be less than or equal :value.","string":"The :attribute must be less than or equal :value characters."},"max":{"array":"The :attribute may not have more than :max items.","file":"The :attribute may not be greater than :max kilobytes.","numeric":"The :attribute may not be greater than :max.","string":"The :attribute may not be greater than :max characters."},"mimes":"The :attribute must be a file of type: :values.","mimetypes":"The :attribute must be a file of type: :values.","min":{"array":"The :attribute must have at least :min items.","file":"The :attribute must be at least :min kilobytes.","numeric":"The :attribute must be at least :min.","string":"The :attribute must be at least :min characters."},"not_in":"The selected :attribute is invalid.","not_regex":"The :attribute format is invalid.","numeric":"The :attribute must be a number.","present":"The :attribute field must be present.","regex":"The :attribute format is invalid.","required":"The :attribute field is required.","required_if":"The :attribute field is required when :other is :value.","required_unless":"The :attribute field is required unless :other is in :values.","required_with":"The :attribute field is required when :values is present.","required_with_all":"The :attribute field is required when :values is present.","required_without":"The :attribute field is required when :values is not present.","required_without_all":"The :attribute field is required when none of :values are present.","same":"The :attribute and :other must match.","size":{"array":"The :attribute must contain :size items.","file":"The :attribute must be :size kilobytes.","numeric":"The :attribute must be :size.","string":"The :attribute must be :size characters."},"string":"The :attribute must be a string.","timezone":"The :attribute must be a valid zone.","unique":"The :attribute has already been taken.","uploaded":"The :attribute failed to upload.","url":"The :attribute format is invalid."},"en.zone":{"address":{"delete":"Delete Address","edit":"Edit Address","name":"Address Name","new":"New Address","sameday_price":"Same Day Price","save":"Save Address","scheduled_price":"Next Day Price"},"addresses":"Zone Addresses","all":"All Zones","charge_per_unit":"Charge Per Unit (KG)","edit":"Edit Zone","extra_fees_per_unit":"Extra Fees Per Charge Unit","label":"Zones","name":"Zone Name","new":"New Zone","no_addresses":"This zone does not have addresses yet!","save":"Save Zone","single":"Zone","standard_weight":"Standard Weight (KG)"}});})();