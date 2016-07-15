// URL String
rootURL     = "http://csis.svsu.edu/";
userNameURL = "~alpero";
healthyuURL = "/healthyu/";
URL         = rootURL + userNameURL + healthyuURL;

// Get ID from URL
function getID() {
    id = window.location.search.substring(1);
    id = id.split("=");
    return id[1];
}