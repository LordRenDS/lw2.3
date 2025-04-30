"use strict";

const output_el = document.getElementById("output");

function plainText(xhr) {
    if (output_el.innerHTML) output_el.innerHTML = "";
    output_el.innerHTML = xhr.responseText;
};

function xml(xhr) {
    let root = xhr.responseXML.getElementsByTagName("response").item(0);
    let rows = root.children
    let table = document.createElement("table");
    for (const column of rows.item(0).children) {
        let th = document.createElement("th");
        th.innerText = column.nodeName;
        table.appendChild(th);
    }
    for (const row of rows) {
        let tr = document.createElement("tr");
        for (const column of row.children) {
            let td = document.createElement("td");
            td.innerText = column.textContent;
            tr.appendChild(td);
        }
        table.appendChild(tr);
    }
    output_el.appendChild(table);
};

function json(html_form_el, uri) {
    fetch(uri, {
        method: "post",
        mode: "same-origin",
        body: new FormData(html_form_el)
    })
        .then((response) => response.json())
        .then((data) => {
            if (output_el.innerHTML) output_el.innerHTML = "";
            printObj(data, output_el);
        })
}

function XHR(html_form_el, uri, onload) {
    let xhr = new XMLHttpRequest();
    xhr.onload = () => { onload(xhr) };
    xhr.open("POST", uri);
    xhr.send(new FormData(html_form_el));
}

function printObj(json_obj, html_p) {
    if (Array.isArray(json_obj) && json_obj.length > 0) {
        html_p.innerText += "[ ";
        for (const val of json_obj) {
            if (typeof (val) === "object")
                printObj(val, html_p);
            else
                html_p.innerText += val + ", ";
        }
        html_p.innerText += " ],\n";
    } else {
        html_p.innerText += "{\n";
        for (const [key, val] of Object.entries(json_obj)) {
            if (typeof (val) !== "object" || val === null)
                html_p.innerText += key + ": " + val + ",\n";
            else if (key === "$date") {
                html_p.innerText += key + ": " + new Date(Number(val["$numberLong"])) + ",\n";
            } else printObj(val, html_p);
        }
        html_p.innerText += " },\n";
    }
}