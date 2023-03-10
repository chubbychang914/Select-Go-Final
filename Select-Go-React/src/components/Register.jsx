import '../css/auth.css';
import { Link } from 'react-router-dom';
import { useState, useEffect, useRef } from 'react';
import { useHistory } from 'react-router-dom';
import axios from 'axios';

import "react-responsive-carousel/lib/styles/carousel.min.css";
import { Carousel } from 'react-responsive-carousel';

import { signInWithFacebook } from '../Firebase';
import { signInWithGoogle } from '../Firebase';
import { useContext } from 'react';
import { LoginContext } from '../Global_State/Context';

import { FacebookLoginButton, GoogleLoginButton } from "react-social-login-buttons";

const Register = () => {
    const history = useHistory();
    // runs only once, if localstorage contains user-info, it'll redirect to /member
    useEffect(() => {
        if (localStorage.getItem('user')) {
            history.push('/');
        }
    }, [history])
    // useRef is a React Hook that allows you to create a reference to a DOM element or a JavaScript object
    const buttonRef = useRef(null);

    // set variables for our registration form
    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [user_phone, setUser_Phone] = useState("");
    const [user_gender, setUser_Gender] = useState("");
    const [user_birthday, setUser_Birthday] = useState("");
    const [error, setError] = useState(false);
    const [errorMsgs, setErrorMsgs] = useState('');
    const [errorType, setErrorType] = useState({ email: false, password: false, phone: false })

    // direct login from register page
    const { setIsLoggedIn } = useContext(LoginContext);
    const googleLogin = () => {
        signInWithGoogle()
            .then((res) => {
                // console.log(res.user)
                localStorage.setItem('token', JSON.stringify(res.user.accessToken));
                localStorage.setItem('user', JSON.stringify(res.user));
                setIsLoggedIn(true);
                history.push('/member')
                window.location.reload(false);
            })
            .catch((err) => {
                alert(err)
            })
    }
    const facebookLogin = () => {
        signInWithFacebook()
            .then((res) => {
                console.log(res.user)
                localStorage.setItem('token', JSON.stringify(res.user.accessToken))
                localStorage.setItem('user', JSON.stringify(res.user))
                setIsLoggedIn(true);
                history.push('/member')
            })
            .catch((err) => {
                alert(err)
            })
    }

    // submit form
    async function handleSubmit(e) {
        e.preventDefault();
        let isValid = true;
        // checks if the required fields are filled in 
        if (!name || !email || !password) {
            isValid = false;
            setError(true);
            if (!name) {
                setErrorMsgs('????????????????????????')
            } else if (!email) {
                setErrorMsgs('????????????????????????')
            } else if (!password) {
                setErrorMsgs('????????????????????????')
            }
            buttonRef.current.scrollIntoView({ behavior: 'smooth', block: 'center', alignToTop: false });
        }
        // only sends request if the required fields are filled
        if (isValid) {
            try {
                // ???????????? data
                let item = { name, email, password, user_phone, user_gender, user_birthday }
                await axios.post('http://localhost:8000/api/register', item, {
                    headers: {
                        'Content-type': 'application/json'
                    }
                })
                    .then(() => {
                        axios.post('http://localhost:8000/api/login', { email: email, password: password },
                            {
                                headers: { 'Content-type': 'application/json', }
                            }
                        )
                            .then((res) => {
                                // console.log(res.data);
                                localStorage.setItem('token', JSON.stringify(res.data.access_token));
                                localStorage.setItem('user', JSON.stringify(res.data.user));
                                setIsLoggedIn(true);
                                history.push('/member');
                                setError(false);
                            })
                    })
            } catch (error) {
                console.log(error);
                setError(true);
                switch (error.response.data.message) {
                    case "wrong email format":
                    case "wrong email format (and 1 more error)":
                    case "wrong email format (and 2 more errors)":
                        setErrorMsgs('Email??????????????????');
                        setErrorType({ ...errorType, email: true });

                        break;
                    case "wrong password format":
                    case "wrong password format (and 1 more error)":
                    case "wrong password format (and 2 more errors)":
                        setErrorMsgs('???????????????????????? 8 ??????');
                        setErrorType({ ...errorType, password: true });
                        break;
                    case "email taken":
                    case "email taken (and 1 more error)":
                    case "email taken (and 2 more errors)":
                        setErrorMsgs('????????????????????????????????????');
                        setErrorType({ ...errorType, email: true });
                        break;
                    case "wrong phone format":
                    case "wrong phone format (and 1 more error)":
                    case "wrong phone format (and 2 more errors)":
                        setErrorMsgs('???????????????????????????');
                        setErrorType({ ...errorType, phone: true });
                        break;
                    default:
                        break;
                }
                buttonRef.current.scrollIntoView({ behavior: 'smooth', block: 'center', alignToTop: false });
                // go to div that shows error
            }
        }
    }

    return (
        <>
            <div className="register-bg-box d-flex justify-content-center align-items-center">
                <div className='register-pic-form d-flex align-items-center justify-content-between'>
                    {/* ===== left side =====*/}
                    <div className='ml-5  w-50' style={{ 'overflow': 'hidden' }}>
                        <Carousel
                            interval={3000}
                            autoPlay={true}
                            infiniteLoop={true}
                            showThumbs={false}
                            showStatus={false}
                            transitionTime={1000}
                        >
                            <div>
                                <img src="/imgs/register/toy.jpeg" alt='carousel' />
                                <p className="legend">????????????????????????????????????</p>
                            </div>
                            <div>
                                <img src="/imgs/register/strawberry.jpeg" alt='carousel' />
                                <p className="legend">?????????????????????????????? ??????????????????????????????</p>
                            </div>
                            <div>
                                <img src="/imgs/register/chocolate.jpeg" alt='carousel' />
                                <p className='legend'>???????????????Shodai Bio Nature~???????????????????????????</p>
                            </div>
                            <div>
                                <img src="/imgs/register/cookie.jpeg" alt='carousel' />
                                <p className='legend'>?????????????????????????????????????????????????</p>
                            </div>
                            <div>
                                <img src="/imgs/register/mushroom.jpeg" alt='carousel' />
                                <p className='legend'>???????????????????????????????????????????????????????</p>
                            </div>
                            <div>
                                <img src="/imgs/register/pudding.jpeg" alt='carousel' />
                                <p className='legend'>??????????????????????????????????????????????????</p>
                            </div>
                            <div>
                                <img src="/imgs/register/shampoo.jpeg" alt='carousel' />
                                <p className="legend"> Maa honey Shampoo ?????????????????????????????????????????????????????</p>
                            </div>
                            <div>
                                <img src="/imgs/register/cat.jpeg" alt='carousel' />
                                <p className='legend'>necono ????????? ??? Luce Bell ??????????????????????????????????</p>
                            </div>
                        </Carousel>
                    </div>

                    {/* ===== right side ===== */}
                    <div className="register-form">
                        <p>???????????????</p>
                        <small className="text-muted mb-2 mt-1"
                            style={{ 'marginTop': `-10px`, 'width': `450px`, 'textAlign': 'center' }}
                        >??????????????????</small>

                        <div className='d-flex'>
                            <div className='mr-4'>
                                <FacebookLoginButton onClick={facebookLogin}
                                    style={{ 'border': `1px solid rgba(0,0,0,0.25)` }}>
                                    <span className='m-3'>??????</span>
                                </FacebookLoginButton>
                            </div>
                            <div>
                                <GoogleLoginButton onClick={googleLogin}
                                    style={{ 'border': `1px solid rgba(0,0,0,0.25)` }}>
                                    <span className='m-3'>??????</span>
                                </GoogleLoginButton>
                            </div>
                        </div>
                        <small className="text-muted mt-2 mb-2"
                            style={{ 'width': `600px`, 'textAlign': 'center' }}
                        >???</small>
                        {/* error message */}
                        <div ref={buttonRef}></div>
                        <div className={`${!error ? "hidden" : ""}`}>
                            <div className='bg-danger px-2 py-3 text-center text-white small mt-3'
                                style={{ 'width': `300px`, 'borderRadius': `5px`, 'border': `1px solid black` }}>
                                {errorMsgs}
                            </div>
                        </div>

                        <form>
                            {/* ============ name ============= */}
                            {name.length < 1 ?
                                <label><i className="fa-solid fa-circle-xmark text-danger" style={{ 'fontSize': `13px` }}></i> ??????</label>
                                :
                                <label><i class="fa-solid fa-circle-check text-success" style={{ 'fontSize': `13px` }}></i> ??????</label>
                            }
                            <div >
                                <input type="text" value={name} onChange={(e) => setName(e.target.value)} id="register-name" placeholder="???????????????" required />
                            </div>
                            {/* ============ email ============= */}
                            {email.length < 1 ?
                                <label><i className="fa-solid fa-circle-xmark text-danger" style={{ 'fontSize': `13px` }}></i> Email</label>
                                :
                                <label><i class="fa-solid fa-circle-check text-success" style={{ 'fontSize': `13px` }}></i> Email</label>
                            }
                            <div>
                                <input type="text" value={email} onChange={(e) => setEmail(e.target.value)} id="register-email" placeholder="?????????Email"
                                    required className={`${error && errorType.email ? "highlight" : ""}`} />
                            </div>
                            {/* ============ password ============= */}
                            {password.length < 8 ?
                                <label><i className="fa-solid fa-circle-xmark text-danger" style={{ 'fontSize': `13px` }}></i> ???????????????????????? 8 ???</label>
                                :
                                <label><i class="fa-solid fa-circle-check text-success" style={{ 'fontSize': `13px` }}></i> ??????</label>
                            }
                            <div>
                                <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} id="register-pwd" placeholder="???????????????"
                                    required className={`${error && errorType.password ? "highlight" : ""}`} />
                            </div>
                            {/* ============ phone ============= */}
                            <label>????????????</label>
                            <div>
                                <input type="text" value={user_phone} onChange={(e) => setUser_Phone(e.target.value)} id="register-phone"
                                    placeholder="?????????????????????" className={`${error && errorType.phone ? "highlight" : ""}`} />
                            </div>

                            <div className='d-flex justify-content-between'>
                                {/* ============ gender ============= */}
                                <div className='d-flex flex-column'>
                                    <label>??????</label>
                                    <div>
                                        <select id="form-gender" name="form-gender" className="custom-select" style={{ opacity: '0.6' }}
                                            value={user_gender} onChange={e => setUser_Gender(e.target.value)}>
                                            <option value="male">???</option>
                                            <option value="female">???</option>
                                            <option value="others">??????</option>
                                        </select>
                                    </div>
                                </div>


                                {/* ============ birthday ============= */}
                                <div className='d-flex flex-column'>
                                    <label>??????</label>
                                    <div>
                                        <input type="date" value={user_birthday} style={{ opacity: '0.5' }}
                                            onChange={(e) => setUser_Birthday(e.target.value)} id="register-birthday" placeholder="?????????????????????" />
                                    </div>
                                </div>
                            </div>


                            <div className="register-btn">
                                <input onClick={handleSubmit}
                                    type="submit" value="??????" />
                            </div>
                        </form>


                        <div className="register-options d-flex flex-column align-items-center">
                            <div className='mt-2'>
                                <span>??????????????????</span>
                                <Link className='text-danger' to="/login" style={{ textDecoration: 'underline' }}>????????????</Link>
                            </div>
                            <div className='text-center mt-4 mb-3' style={{ fontSize: `5px` }}>
                                ?????????????????????????????????????????????Select Go???
                                <br />
                                ???????????? ??? ???????????????
                            </div>
                        </div>
                    </div>
                </div >
            </div >

        </>
    );
}

export default Register;