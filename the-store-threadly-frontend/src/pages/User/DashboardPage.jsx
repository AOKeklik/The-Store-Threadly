import React from 'react'
import Baner from './../../components/layouts/Baner';
import UserAddress from '../../components/user/UserAddress';
import UserProfile from '../../components/user/UserProfile';

export default function DashboardPage() {

    

    return <div className='pb-5'>
        <Baner {...{
            title: "Dashboard",
            breadcrumbs: [
                {path: "",label:"Dashboard"},
            ],
        }} />

        <main className="container-md mb-5">
            <div className="row mt-4">
                {/* Sidebar (Left Column) */}
                <div className="col-md-3">
                    <ul className="nav flex-column nav-pills" role="tablist">
                        <li className="nav-item">
                            <a
                                className="nav-link active"
                                id="profile-tab"
                                data-bs-toggle="pill"
                                href="#profile"
                                role="tab"
                                aria-controls="profile"
                                aria-selected="true"
                            >
                                Profile
                            </a>
                        </li>
                        <li className="nav-item">
                            <a
                                className="nav-link"
                                id="address-tab"
                                data-bs-toggle="pill"
                                href="#address"
                                role="tab"
                                aria-controls="address"
                                aria-selected="false"
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
                            <UserProfile />
                        </div>
                        <div
                            className="tab-pane fade"
                            id="address"
                            role="tabpanel"
                            aria-labelledby="address-tab"
                        >
                            <UserAddress />
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
}
