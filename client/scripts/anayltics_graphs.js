new Chart(document.getElementById("bar-chart-horizontal"), {
            type: 'horizontalBar',
            data: {
            labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
            datasets: [
                {
                label: "Candidates",
                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                data: [12, 4, 12, 43, 11]
                }
            ]
            },
            options: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Candidate Diversity Breakdown'
            }
            }
        });