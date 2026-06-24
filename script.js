async function loadInterns(){

    try{

        const response =
        await fetch("get_interns.php");

        if(!response.ok){
            throw new Error("Failed");
        }

        const interns =
        await response.json();

        let container =
        document.getElementById(
        "internContainer"
        );

        container.innerHTML = "";

        interns.forEach(intern => {

            let card =
            document.createElement("div");

            card.className = "card";

            card.innerHTML = `
            <h3>${intern.name}</h3>
            <p>${intern.email}</p>
            <p>${intern.college}</p>
            `;

            container.appendChild(card);

        });

    }

    catch(error){
        alert(error.message);
    }
}

async function addIntern(){

    let name =
    document.getElementById("name").value;

    let email =
    document.getElementById("email").value;

    let college =
    document.getElementById("college").value;

    try{

        const response =
        await fetch("add_intern.php",{

            method:"POST",

            headers:{
                "Content-Type":
                "application/json"
            },

            body:JSON.stringify({
                name,
                email,
                college
            })

        });

        const result =
        await response.json();

        alert(result.message);

        loadInterns();

    }

    catch(error){

        alert(error.message);

    }

}
