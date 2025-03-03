// ============================================================================
// Module      : iab/intents/intents.js
// Version     : 1.0
//
// Author      : Denis Patrice <denispatrice@yahoo.com>
// Copyright   : Copyright (c) Denis Patrice Dipl.-Ing. 2010-2025
//               All rights reserved
//
// Application : global/cordova InAppBrowser-based application
// Description : InAppBrowser server intents API
//
// Date+Time of change   By     Description
// --------------------- ------ ----------------------------------------------
// 20-Jan-25 00:00 WIT   Denis  Deployment V. 2025 "Raymond Chandler"
//
// ============================================================================

var intents = {

	// **************************************************************************
	// **************************************************************************
	//
	// Implementation
	//
	// **************************************************************************
	// **************************************************************************

	onmessage : function(message, isBackgroundMessage, isClickedMessage)
	{
		return new Promise(
			(resolve, reject)=>{
				/*
				var msg = "IN intents.onmessage()"
								+ " isBackgroundMessage=" + String(isBackgroundMessage) 
								+ " isClickedMessage="    + String(isClickedMessage);
				console.info(msg);
				console.log(JSON.stringify(message));
				*/
				var dataType = message["dataType"];
				//console.log("IN intents.onmessage() dataType='" + dataType + "'");

				switch(dataType) {

					case "RQ_SID" : {
						iab_browser.response("RQ_SID", application.sid)
						resolve();
						break;
					}

					case "SET_IPC_PIN" : {
						var data = message["data"];
						console.log(JSON.stringify(data));
						ipc.pin = data["pin"];
						console.log("intents IPC pin set to ipc.pin='" + ipc.pin + "'");
						iab_browser.response("SET_IPC_PIN", "1000");
						resolve();
						break;
					}

					default : {
						//console.warn("I do not know dataType='" + dataType + "'");
						reject();
						break;
					}
				}

			}
		);
	},

	onshow : function()
	{
		//console.info("IN intents.onshow()");
		/*
		jQuery("#BTN_TEST").on("click", function(){
			var fname = "session_data";
			var arguments = {
				sid: application.sid,
				variable_id : "instant",
				value : datetime.sql()
			};
			
			//console.log(fname);
			//console.log(arguments);

			var libraries = [];
			var runargs = {};
			//console.log(runargs);

			run(fname, arguments, libraries, runargs)
			.then ((result)=>{
				//console.log("Resolved by run()");
				//console.log(result);
			})
			.catch(()=>{
				//console.error("Rejected by run()");
			});

		});
		*/
	},


	// **************************************************************************
	// **************************************************************************
	//
	// Initialization
	//
	// **************************************************************************
	// **************************************************************************

	init : function() 
	{
		console.info("IN intents.init()");
		ipc.dispatcher.reg("*", intents.onmessage);
	}

};


// End of file: iab/intents/intents.js
// ============================================================================