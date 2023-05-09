export type Route = {
    link?: string,
    linkName: string,
    submenu?: {
        link: string,
        linkName: string,
    }[],
}

export type BaseRoute = {
    linkName: string,
}

export type TopLevelRoute = BaseRoute & {
    link: string,
}

export type DropdownRoute = BaseRoute & {
    submenu?: {
        link: string,
        linkName: string,
    }[]
}

export type Gates = {
    'route.access-admin': boolean,
    'route.access-intern': boolean,
}

/**
 * Call this function with this parameter: `usePage().props.auth.can`.
 */
export function useRoutes(gates?: Gates): (TopLevelRoute | DropdownRoute)[] {
    let routes: Route[] = [
        {link: '/', linkName: 'Home'},
        {
            linkName: 'Aktuelles',
            submenu: [
                {link: '/auftritte', linkName: 'Auftritte'},
                {link: '/presse', linkName: 'Presseinfos'},
                {link: '/buchung', linkName: 'Buchungsinfos'}
            ],
        },
        {
            linkName: 'Band',
            submenu: [
                {link: '/about-us', linkName: 'Über uns'},
                {link: '/musiker', linkName: 'Musiker'},
                {link: '/anfahrt', linkName: 'Anfahrt'}
            ],
        },
        {
            linkName: 'Kontakt',
            submenu: [
                {link: '/kontakt', linkName: 'Kontakt'},
                {link: '/impressum', linkName: 'Impressum'},
            ],
        },
    ];
    if (gates["route.access-intern"]) {
        routes.push({
            linkName: 'Intern',
            submenu: [
                {link: '/intern/emails', linkName: 'E-Mail Verteiler'},
                {link: '/intern/songs', linkName: 'Songs'}
            ],
        })
    }
    if (gates["route.access-admin"]) {
        routes.push({
            linkName: 'Admin',
            submenu: [
                {link: '/admin/activate-users', linkName: 'Aktiviere User'},
                {link: '/admin/roles', linkName: 'Rollen Management'},
                {link: '/admin/musicians', linkName: 'Musiker Management'},
                {link: '/admin/songs', linkName: 'Song Management'},
            ]
        })
    }
    return routes;
}
