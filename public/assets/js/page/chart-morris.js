// $(function () {
//     getMorris("line", "line_chart");
//     getMorris("bar", "bar_chart");
//     getMorris("area", "area_chart");
//     getMorris("donut", "donut_chart");
// });

// function getMorris(type, element) {
//     if (type === "area") {
//         Morris.Area({
//             element: element,
//             data: [
//                 { w: "Jan", x: 2, y: 0, z: 0 },
//                 { w: "Feb ", x: 50, y: 15, z: 5 },
//                 { w: "Mar", x: 15, y: 50, z: 23 },
//                 { w: "Apr", x: 45, y: 12, z: 7 },
//                 { w: "May", x: 20, y: 32, z: 55 },
//                 { w: "Jun", x: 39, y: 67, z: 20 },
//                 { w: "Jul", x: 20, y: 9, z: 5 },
//             ],
//             xkey: "w",
//             parseTime: false,
//             ykeys: ["a"],
//             ykeys: ["x", "y", "z"],
//             labels: ["X", "Y", "Z"],
//             xLabels: "month",
//             pointSize: 0,
//             lineWidth: 0,
//             resize: true,
//             fillOpacity: 0.8,
//             behaveLikeLine: true,
//             gridLineColor: "#e0e0e0",
//             hideHover: "auto",
//             lineColors: [
//                 "rgb(1, 101, 225)",
//                 "rgb(29, 155, 240)",
//                 "rgb(193,53, 132)",
//             ],
//         });
//     }
// }
