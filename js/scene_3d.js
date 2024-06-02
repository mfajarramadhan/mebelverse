import * as THREE from "https://cdn.skypack.dev/three@0.129.0/build/three.module.js";
import { GLTFLoader } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js";
import { RGBELoader } from 'https://cdn.skypack.dev/three@0.136.0/examples/jsm/loaders/RGBELoader.js';
import { OrbitControls } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js";

let container;
let camera, scene, renderer;
let controls;

container = document.getElementById( 'scene' );
const rect = container.getBoundingClientRect();
var scene_height = rect.height;
var scene_width = rect.width;

init();
animate();

function init() {

    scene = new THREE.Scene();
    camera = new THREE.PerspectiveCamera( 55, scene_width / scene_height, .01, 100 );
    camera.position.set( 0, 1.2, 3 );
    controls = new OrbitControls( camera, container );

    controls.target.set( 0, 1.2, 0 );
    // controls.enabled = false;
    controls.enableZoom = false;
    controls.enableDamping = true;
    controls.dampingFactor = .1;
    controls.autoRotate = true;
    controls.autoRotateSpeed = 5;





    // MY STUFFS ===============================================================================================

    // FOG
    // scene.fog = new THREE.Fog(0xf5edab, 16, 100);

    // Load GLTF
    const loader = new GLTFLoader();
    let obj;
    var file = './img/produk_gltf/' + nama_file;
    loader.load(
        file,
        function (gltf) {
            let object = gltf;
            obj = object.scene;
            scene.add(obj);
            obj.position.x = 0; obj.scale.x = .6; obj.scale.y = .6; obj.scale.z = .6;
            obj.traverse(function (child) {
                if (child.isMesh) {
                child.castShadow = true;
                }
            });
        },
        function (xhr) {
        if(xhr.loaded == xhr.total) {
            console.log('100% loaded');
        }
        },
        function (error) {console.error(error);}
    );
    

    // Create a light
    const light = new THREE.PointLight(0xffffff, 1.7);
    light.position.set(-10, 10, 10);
    scene.add(light);
    light.castShadow = true;
    light.shadow.mapSize.width = 2048; // Increase for higher-quality shadows
    // light.shadow.camera.near = 0.5; // Adjust near and far planes for shadow distance
    // light.shadow.camera.far = 500;
    
    // AMBIENT LIGHT
    const ambiLight = new THREE.AmbientLight(0xdddddd);
    scene.add(ambiLight);

    // MY STUFFS ===============================================================================================










    renderer = new THREE.WebGLRenderer( { antialias: true, alpha: true } );
    renderer.setPixelRatio( window.devicePixelRatio );
    renderer.setSize( scene_width, scene_height );
    renderer.shadowMap.enabled = true;

    container.appendChild( renderer.domElement );

    const geometry = new THREE.BufferGeometry().setFromPoints( [ new THREE.Vector3( 0, 0, 0 ), new THREE.Vector3( 0, 0, - 1 ) ] );


    // Floor
    // const floorGeometry = new THREE.PlaneGeometry(100, 100);
    // const floorMaterial = new THREE.MeshBasicMaterial({ color: 'rgb(183, 203, 216)' });
    // const floor = new THREE.Mesh(floorGeometry, floorMaterial);
    // floor.receiveShadow = true;
    // floor.rotation.x = -Math.PI / 2;
    // scene.add(floor);
    
    
    // GEOMETRY (SPHERE)
    // const SphereGeometry = new THREE.SphereGeometry(.8, 64, 64);
    // const material = new THREE.MeshStandardMaterial({color: "#3388ff"})
    // const mesh = new THREE.Mesh(SphereGeometry, material);
    // scene.add(mesh);
    // mesh.position.z = 0;
    // mesh.position.x = 0;


    window.addEventListener( 'resize', onWindowResize );
    
}

function onWindowResize() {
    camera.aspect = scene_width / scene_height;
    camera.updateProjectionMatrix();
    renderer.setSize( scene_width, scene_height );
}



function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
}

function render() {
    renderer.render( scene, camera );
}