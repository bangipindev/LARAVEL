$(function(){
    $("#sharePopup").jsSocials({
        showCount: true,
        showLabel: true,
        shareIn: "popup",
        shares: [
            { share: "twitter", label: "Twitter" },
            { share: "facebook", label: "Facebook" },
            { share: "whatsapp", label: "WhatsApp" },
        ]
    });
});