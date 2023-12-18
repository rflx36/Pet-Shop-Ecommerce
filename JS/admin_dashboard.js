function openTab(tabName) {
    var i, tabContent;
    tabContent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }
    document.getElementById(tabName).style.display = "block";

    // Load the chart data for the selected tab
    if (tabName === 'day') {
        loadChart('day', 'This Day');
    } else if (tabName === 'week') {
        loadChart('week', 'This Week');
    } else if (tabName === 'month') {
        loadChart('month', 'This Month');
    }
}

// Initial load
openTab('day');