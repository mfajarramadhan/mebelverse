import * as THREE from "https://cdn.skypack.dev/three@0.129.0/build/three.module.js";
import { GLTFLoader } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js";
import { OrbitControls } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js";


var container = [];
var camera = [];
var scene = [];
var renderer = [];
var controls = [];

container = [];

for(var i = 1; i <= jum_scene_3d; i++) {
    init(i, nama_file_gltf[i]);
}


function init(index, nama_file) {

    container[index] = document.getElementById( 'scene_' + index );
    var rect = container[index].getBoundingClientRect();
    var scene_height = rect.height;
    var scene_width = rect.width;
    
    scene[index] = new THREE.Scene();
    camera[index] = new THREE.PerspectiveCamera( 55, scene_width / scene_height, .01, 100 );
    camera[index].position.set( 0, 1.2, 3 );

    renderer[index] = new THREE.WebGLRenderer( { antialias: true, alpha: true } );
    renderer[index].setPixelRatio( window.devicePixelRatio );
    renderer[index].setSize( scene_width, scene_height );
    renderer[index].shadowMap.enabled = true;
    


    controls[index] = new OrbitControls( camera[index], container[index] );
    controls[index].target.set( 0, 1.2, 0 );
    controls[index].enableZoom = false;
    controls[index].autoRotate = true;
    controls[index].enableDamping = true;
    controls[index].dampingFactor = .1;
    controls[index].autoRotateSpeed = 4;
    // controls[index].update();

    // MY STUFFS ===============================================================================================

    // Load Room
    const loader = new GLTFLoader();
    let obj;
    var file = './img/produk_gltf/' + nama_file;
    loader.load(
        file,
        function (gltf) {
            let object = gltf;
            obj = object.scene;
            scene[index].add(obj);
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
    scene[index].add(light);
    light.castShadow = true;
    light.shadow.mapSize.width = 2048;    
    // AMBIENT LIGHT
    const ambiLight = new THREE.AmbientLight(0xdddddd);
    scene[index].add(ambiLight);

    // MY STUFFS ===============================================================================================





    container[index].appendChild( renderer[index].domElement );
    
    renderer[index].setAnimationLoop(()=> {
        controls[index].update();
        renderer[index].render( scene[index], camera[index] );
    });
    window.addEventListener( 'resize', () => {
        camera[index].aspect = scene_width / scene_height;
        camera[index].updateProjectionMatrix();
        renderer[index].setSize( scene_width, scene_height );
    } );
    
}