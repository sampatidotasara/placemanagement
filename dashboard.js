loadStatusChart();
loadCompanyChart();
loadMonthlyChart();

async function loadStatusChart(){

const response =
await fetch(
'api/dashboardStats.php'
);

const data =
await response.json();

new Chart(

document.getElementById(
'statusChart'
),

{
type:'pie',

data:{

labels:[
'Selected',
'Rejected',
'Pending'
],

datasets:[{

data:[

data.selected,
data.rejected,
data.pending

]

}]
}
}
);

}

async function loadCompanyChart(){

const response =
await fetch(
'api/companyStats.php'
);

const data =
await response.json();

let labels=[];
let values=[];

data.forEach(item=>{

labels.push(
item.company_name
);

values.push(
item.total
);

});

new Chart(

document.getElementById(
'companyChart'
),

{
type:'bar',

data:{

labels:labels,

datasets:[{

label:'Applications',

data:values

}]

}
}
);

}

async function loadMonthlyChart(){

const response =
await fetch(
'api/monthlyStats.php'
);

const data =
await response.json();

let labels=[];
let values=[];

data.forEach(item=>{

labels.push(
"Month " + item.month
);

values.push(
item.total
);

});

new Chart(

document.getElementById(
'monthlyChart'
),

{
type:'line',

data:{

labels:labels,

datasets:[{

label:'Applications',

data:values,

fill:false

}]
}
}
);

}
