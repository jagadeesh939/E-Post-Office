function trackParcel() {
    let trackingId = document.getElementById("tracking-id").value;
    let result = document.getElementById("result");

    if (trackingId === "123456") {
        result.innerHTML = "Your parcel is on the way!";
    } else {
        result.innerHTML = "Invalid Tracking ID!";
    }
}
