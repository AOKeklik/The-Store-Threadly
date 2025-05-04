import React from 'react'

import Baner from './../../components/layouts/Baner'
import UserAddress from '../../components/user/UserAddress'
import UserProfile from '../../components/user/UserProfile'
import UserPassword from '../../components/user/UserPassword'
import useProfile from '../../hooks/profile/useProfile'
import Loader from './../../components/layouts/Loader';

export default function DashboardPage() {

    const {
        profile,
        isLoadingProfile,
    } = useProfile()
    

    if(isLoadingProfile) return <Loader fullHeight />

    return <div className='pb-5'>
        <Baner {...{
            title: "Dashboard",
            breadcrumbs: [
                {path: "",label:"Dashboard"},
            ],
        }} />

        <main className="container-md mb-5">
            <div className="row mt-4 g-5">
                {/* Sidebar (Left Column) */}
                <div className="col-md-3">
                    <ul className="nav flex-column nav-pills" role="tablist">
                        <li className="nav-item">
                            <a
                                href="#profile"
                                id="profile-tab"
                                className="nav-link active"
                                data-bs-toggle="pill" role="tab" aria-controls="profile" aria-selected="true"
                            >
                                Profile
                            </a>
                        </li>
                        <li className="nav-item">
                            <a
                                className="nav-link"
                                id="password-tab"
                                href="#password"
                                data-bs-toggle="pill" role="tab" aria-controls="password" aria-selected="false"
                            >
                                Password
                            </a>
                        </li>
                        <li className="nav-item">
                            <a
                                className="nav-link"
                                id="address-tab"
                                href="#address"
                                data-bs-toggle="pill" role="tab" aria-controls="address" aria-selected="false"
                            >
                                Address
                            </a>
                        </li>
                    </ul>
                </div>

                {/* Content (Right Column) */}
                <div className="col-md-9">
                    <div className="tab-content">
                        <div
                            className="tab-pane fade show active"
                            id="profile"
                            role="tabpanel"
                            aria-labelledby="profile-tab"
                        >
                            <UserProfile profile={profile} />
                        </div>
                        <div
                            className="tab-pane fade"
                            id="password"
                            role="tabpanel"
                            aria-labelledby="password-tab"
                        >
                            <UserPassword />
                        </div>
                        <div
                            className="tab-pane fade"
                            id="address"
                            role="tabpanel"
                            aria-labelledby="address-tab"
                        >
                            <UserAddress profile={profile} />
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
}
