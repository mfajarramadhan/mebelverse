import * as THREE from "https://cdn.skypack.dev/three@0.129.0/build/three.module.js";
import { GLTFLoader } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/loaders/GLTFLoader.js";
import { RGBELoader } from 'https://cdn.skypack.dev/three@0.136.0/examples/jsm/loaders/RGBELoader.js';
import { OrbitControls } from "https://cdn.skypack.dev/three@0.129.0/examples/jsm/controls/OrbitControls.js";
import { VRButton } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/webxr/VRButton.js';
import { XRControllerModelFactory } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/webxr/XRControllerModelFactory.js';
import { XRHandModelFactory } from 'https://cdn.skypack.dev/three@0.129.0/examples/jsm/webxr/XRHandModelFactory.js';

let container;
let camera, scene, renderer;
let hand1, hand2;
let controller1, controller2;
let controllerGrip1, controllerGrip2;
let controls;
let controller;
const loader = new GLTFLoader();
var total_loaded = 0;
var black_fade = document.getElementById('black_fade');
var loading_log = document.getElementById('loading_log');


init();
animate();



function init() {


    // BASICS =========================================================================================================
    // ================================================================================================================
        // SCENE INIT
            container = document.getElementById( 'scene' );
            scene = new THREE.Scene();
            scene.background = new THREE.Color( 0x444444 );

        // CAMERA
            camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, .01, 100 );
            camera.position.set( 0, 1.6, 1 );

        // ORBIT CONTROLS
            controls = new OrbitControls( camera, container );
            controls.target.set( 0, 1.6, 0 );
            controls.update();
            controls.enableDamping = true;
            controls.dampingFactor = .1;
    // ================================================================================================================
    // BASICS =========================================================================================================






    // MY STUFFS ======================================================================================================
    // ================================================================================================================
        // HDRI BG
        // const rgbeLoader = new RGBELoader();
        // rgbeLoader.load('../assets/hdr/cape_hill_4k.hdr', (texture) => {
            // texture.mapping = THREE.EquirectangularReflectionMapping;
            // scene.background = texture;
            // renderer.render(scene, camera);
        // });

        // FOG
        scene.fog = new THREE.Fog(0xf5edab, 16, 100);

        // GLTF
        setTimeout(() => {
            for(var i = 0; i < produk_items.length; i++) {
                loadGLTF(scene, produk_items[i], (i * 3));
                total_loaded++;
                if(total_loaded < produk_items.length) {
                    loading_log.innerHTML = total_loaded + "/" + produk_items.length + " products get loaded...";
                } else {
                    loading_log.innerHTML = "All products get loaded";
                    setTimeout(() => {
                        setTimeout(() => {
                            loading_log.style.animation = "loading_log 2s forwards";
                        }, 1000);
                        black_fade.style.animation = "black_fade 1.75s forwards";
                    }, 400);
                }
            }
        }, 500);
        
        // POINT LIGHT
        const light = new THREE.PointLight(0xffffff, 1.5);
        light.castShadow = true;
        light.position.set(-10, 10, 10);
        scene.add(light);
        
        // AMBIENT LIGHT
        const ambiLight = new THREE.AmbientLight(0x8888bb);
        scene.add(ambiLight);
    // ================================================================================================================
    // MY STUFFS ======================================================================================================






    // RENDERER =======================================================================================================
    // ================================================================================================================
        renderer = new THREE.WebGLRenderer( { antialias: true } );
        renderer.setPixelRatio( window.devicePixelRatio );
        renderer.setSize( window.innerWidth, window.innerHeight );
        renderer.shadowMap.enabled = true;
        renderer.xr.enabled = true;
        container.appendChild( renderer.domElement );
        document.body.appendChild( VRButton.createButton( renderer ) );
        window.addEventListener( 'resize', onWindowResize );
    // ================================================================================================================
    // RENDERER =======================================================================================================
    
        
    
    
    
    
    // IMMERSIVE CONTROL SETUP ========================================================================================
    // ================================================================================================================
        controller1 = renderer.xr.getController( 0 );
        controller2 = renderer.xr.getController( 1 );
        scene.add( controller2 );
        const controllerModelFactory = new XRControllerModelFactory();
        const handModelFactory = new XRHandModelFactory();
        
        // Hand 1
            controllerGrip1 = renderer.xr.getControllerGrip( 0 );
            controllerGrip1.add( controllerModelFactory.createControllerModel( controllerGrip1 ) );
            scene.add( controllerGrip1 );
            hand1 = renderer.xr.getHand( 0 );
            hand1.add( handModelFactory.createHandModel( hand1 ) );
            scene.add( hand1 );

        // Hand 2
            controllerGrip2 = renderer.xr.getControllerGrip( 1 );
            controllerGrip2.add( controllerModelFactory.createControllerModel( controllerGrip2 ) );
            scene.add( controllerGrip2 );
            hand2 = renderer.xr.getHand( 1 );
            hand2.add( handModelFactory.createHandModel( hand2 ) );
            scene.add( hand2 );

        const geometry = new THREE.BufferGeometry().setFromPoints( [new THREE.Vector3( 0, 0, 0 ), new THREE.Vector3( 0, 0, - 1 ) ] );

        const line = new THREE.Line( geometry ); line.name = 'line';
        line.scale.z = 5;

        controller1.add( line.clone() );
        controller2.add( line.clone() );
    // ================================================================================================================
    // IMMERSIVE SETUP ================================================================================================





    
    // XR CONTROLLERS =================================================================================================
    // ================================================================================================================
        controller1.addEventListener( 'selectstart', (event) => {
            mesh.position.y += .6;
        });
        controller1.addEventListener( 'selectend', (event) => {
            mesh.position.y -= .6;
        });
        controller1.addEventListener( 'squeezestart', (event) => {
            mesh.position.x += .7;
        });
        controller1.addEventListener( 'squeezeend', (event) => {
            mesh.position.x -= .7;
        });
    // ================================================================================================================
    // XR CONTROLLERS =================================================================================================

    
}










function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize( window.innerWidth, window.innerHeight );
}
function animate() {renderer.setAnimationLoop( render );}
function render() {renderer.render( scene, camera );}
function loadGLTF(scene_to_add, file_to_load, position_to_put) {
    loader.load(
        './img/produk_gltf/' + file_to_load,
        function (gltf) {
            let object = gltf;
            scene_to_add.add(object.scene);
            let obj = object.scene;
            obj.position.y = -1.7;
            obj.position.x = position_to_put;
            obj.scale.set(.7, .7, .7);
            obj.traverse(function (child) {
                if (child.isMesh) {
                // child.castShadow = true;
                child.castShadow = true;
                }
            });
        },
        function (xhr) {if(xhr.loaded == xhr.total) {console.log('100% loaded');}},
        function (error) {console.error(error);}
    );
}