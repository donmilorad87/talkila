function RECONNECT_TO_ROOM_Send_Event_Function(call) {
    sendEvents(Events.RECONNECT_TO_ROOM, {}, call)
}

function SUPPLIER_SET_CLIENT_AUDIO_OFF_Send_Event_Function(call, participant_identity) {
    sendEvents(Events.SUPPLIER_SET_CLIENT_AUDIO_OFF, {
        user_id: parseInt(participant_identity)
    }, call)
}

function SUPPLIER_SET_CLIENT_TO_AUDIO_ON_Send_Event_Function(call, participant_identity) {
    sendEvents(Events.SUPPLIER_SET_CLIENT_TO_AUDIO_ON, {
        user_id: parseInt(participant_identity)
    }, call)
}

function SUPPLIER_SET_CLIENT_VIDEO_OFF_Send_Event_Function(call, participant_identity) {
    sendEvents(Events.SUPPLIER_SET_CLIENT_VIDEO_OFF, {
        user_id: parseInt(participant_identity)
    }, call)
}

function SUPPLIER_SET_CLIENT_VIDEO_ON_Send_Event_Function(call, participant_identity) {
    sendEvents(Events.SUPPLIER_SET_CLIENT_VIDEO_ON, {
        user_id: parseInt(participant_identity)
    }, call)
}

function KICK_PARTICIPANT_Send_Event_Function(call, participant_identity, reason) {
    sendEvents(Events.KICK_PARTICIPANT, {
        user_id: parseInt(participant_identity),
        // TODO: Pass the reason here
        reason: String(getPoTranslate('SUPPLIER_KICKED_STUDENT_FROM_TALK'))
    }, call)
}

function EXTEND_CALL_ACCEPT_Send_Event_Function(call,data) {

    sendEvents(Events.EXTEND_CALL_ACCEPT, {
        client_id: parseInt(data.client_id)
    }, call)

}

function EXTEND_CALL_REJECT_Send_Event_Function(call, data) {

    sendEvents(Events.EXTEND_CALL_REJECT, {
        client_id: parseInt(data.client_id)
    }, call)
}

function EXTEND_CALL_SUCCESSFUL_Send_Event_Function(call, userObj, extendTalkParametersArray) {

    sendEvents(Events.EXTEND_CALL_SUCCESSFUL, {
        minutes_increased: parseInt(extendTalkParametersArray[0]),
        provider_id: parseInt(call.provider_id),
        client_name: String(userObj.name),
        client_profile_picture: String(userObj.profile_picture),
        extension_minutes: parseInt(extendTalkParametersArray[0]),
        extension_price: parseFloat(extendTalkParametersArray[1].replace(',', '.'))
    }, call)

}

function EXTEND_CALL_REQUEST_Send_Event_Function(call, userObj) {

    sendEvents(Events.EXTEND_CALL_REQUEST, {

        user_full_name: String(userObj.name),
        profile_picture: String(userObj.profile_picture),
        minutes_increased: parseInt(document.getElementById('extendLessonTime').value),
        payment_amount: parseFloat(document.getElementById('priceHours').value.replace(',', '.'))

    }, call)

}

function PICKUP_Send_Event_Function(call) {
    sendEvents(Events.PICKUP, {}, call)
}

function REDIAL_Send_Event_Function(call) {
    sendEvents(Events.REDIAL, {}, call)
}

function HANGUP_Send_Event_Function(call, reason) {

    if (call.user_type == UserTypes.CLIENT) {
        clearInterval(checkForExtendionInterval)
    }

    sendEvents(Events.HANGUP, {
        reason: parseInt(reason)
    }, call);

    window.localStorage.removeItem('call');

}

function GROUP_SUPPLIER_SET_ALL_AUDIO_OFF_Send_Event_Function(call) {
    sendEvents(Events.GROUP_SUPPLIER_SET_ALL_AUDIO_OFF, {}, call)
}

function GROUP_SUPPLIER_SET_ALL_AUDIO_ON_Send_Event_Function(call) {
    sendEvents(Events.GROUP_SUPPLIER_SET_ALL_AUDIO_ON, {}, call)
}

function GROUP_SUPPLIER_SET_ALL_VIDEO_OFF_Send_Event_Function(call) {
    sendEvents(Events.GROUP_SUPPLIER_SET_ALL_VIDEO_OFF, {}, call)
}

function GROUP_SUPPLIER_SET_ALL_VIDEO_ON_Send_Event_Function(call) {
    sendEvents(Events.GROUP_SUPPLIER_SET_ALL_VIDEO_ON, {}, call)
}

function AUDIO_OFF_Send_Event_Function(call) {
    sendEvents(Events.AUDIO_OFF, {}, call)
}

function AUDIO_ON_Send_Event_Function(call) {
    sendEvents(Events.AUDIO_ON, {}, call)
}

function VIDEO_OFF_Send_Event_Function(call) {
    sendEvents(Events.VIDEO_OFF, {}, call)
}

function VIDEO_ON_Send_Event_Function(call) {
    sendEvents(Events.VIDEO_ON, {}, call)
}

function CLIENT_RAISE_HAND_Send_Event_Function(call) {
    sendEvents(Events.CLIENT_RAISE_HAND, {}, call)
}

function SUPPLIER_ACCEPT_RAISED_HAND_Send_Event_Function(call, client_id) {
    sendEvents(Events.SUPPLIER_ACCEPT_RAISED_HAND, {client_id}, call)
}

function SUPPLIER_REJECT_RAISED_HAND_Send_Event_Function(call, client_id) {
    sendEvents(Events.SUPPLIER_REJECT_RAISED_HAND, {client_id}, call)
}
