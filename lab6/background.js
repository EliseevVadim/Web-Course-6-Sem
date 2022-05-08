chrome.runtime.onInstalled.addListener(() => {
    alert('Расширение успешно установлено');
});

chrome.browserAction.onClicked.addListener(function(activeTab)
{
    let newURL = "http://localhost:8080";
    chrome.tabs.create({ url: newURL });
});