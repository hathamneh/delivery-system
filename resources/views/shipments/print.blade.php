@php /** @var \App\Shipment $shipment */ @endphp

@extends('layouts.print')

@section('content')
    <div class="container">

        <section class="shipments-print sheet ">
            <table class="w-100" cellpadding="6">
                <tr>
                    <td colspan="2" class="border-bottom">
                        <div class="d-flex justify-content-between p-3 align-items-center">

                            <div class="invoice-logo" style="flex: 1;">
                                <img src="/images/logo-fullxhdpi.png" alt="Logo" style="height: 60px;">
                            </div>
                            <div class="text-center" style="flex: 2;">
                                <h1>Shipment Details</h1>
                            </div>
                            <div style="flex: 1;">
                                <div class="text-right">
                                    <b>Date: </b> {{ now()->toFormattedDateString() }}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table class="table table-bordered">
                            <tr>
                                <th style="vertical-align: middle;">
                                    @lang('shipment.waybill'):
                                </th>
                                <td colspan="3"><b style="font-size: 1.25rem;">{{ $shipment->waybill }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="divider"><i class="fa-user-tie"></i> Client Info</td>
                            </tr>
                            @if($shipment->is_guest)
                                @include('shipments.print.client-guest')
                            @else
                                @include('shipments.print.client-registered')
                            @endif

                            <tr>
                                <td colspan="4" class="divider"><i class="fa-info-circle"></i> Delivery Details</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.delivery_date')
                                </th>
                                <td>
                                    {{ $shipment->delivery_date }}
                                </td>
                                <th>
                                    @lang('shipment.package_weight')
                                </th>
                                <td>{{ $shipment->package_weight }}</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.pieces')
                                </th>
                                <td>{{ $shipment->pieces }}</td>
                                <th>
                                    @lang('shipment.shipment_value')
                                </th>
                                <td>{{ $shipment->shipment_value }}</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.status')
                                </th>
                                <td>{{ $shipment->status->identifiableName() }}</td>
                                <th>
                                    @lang('shipment.custom_price')
                                </th>
                                <td>
                                    {{ is_null($shipment->total_price) ? trans('common.no') : (trans('common.yes') . ' ( '.$shipment->total_price .' )') }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.extra_services')
                                </th>
                                <td colspan="3">
                                    @include('shipments.print.services')
                                </td>
                            </tr>
                            <tr>
                                <td class="divider" colspan="4">
                                    <i class="fa-truck"></i> Consignee's information
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.consignee_name')
                                </th>
                                <td>{{ $shipment->consignee_name }}</td>
                                <th>
                                    @lang('shipment.phone_number')
                                </th>
                                <td>{{ $shipment->phone_number }}</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('accounting.address')
                                </th>
                                <td>{{ $shipment->address->name }}</td>
                                <th>
                                    @lang('shipment.address_maps_link')
                                </th>
                                <td>{{ $shipment->address_maps_link }}</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.address_sub_text')
                                </th>
                                <td colspan="3">
                                    {{ $shipment->address_sub_text }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.courier')
                                </th>
                                <td>{{ $shipment->courier->name }}</td>
                                <th>
                                    @lang('shipment.internal_notes')
                                </th>
                                <td>{{ $shipment->internal_notes }}</td>
                            </tr>
                            <tr>
                                <td class="divider" colspan="4">More</td>
                            </tr>
                            <tr>
                                <th>
                                    @lang('shipment.delivery_cost_lodger.label')
                                </th>
                                <td>{{ trans('shipment.delivery_cost_lodger.'.$shipment->delivery_cost_lodger) }}</td>
                                <th>
                                    @lang('shipment.reference')
                                </th>
                                <td>{{ $shipment->reference }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>


                <tr>
                    <td colspan="2">
                        <div class="coc">
                            <div class="coc-title">
                                CONDITIONS OF CARRIAGE
                            </div>
                            <div class="coc-body">
                                In tendering the shipment for carriage, the customer agrees to these terms and
                                conditions of
                                carriage and that this waybill is NON-NEGOTIABLE and has been prepared by the customer
                                or on the
                                customer’s behalf by Kangaroo Express Delivery Company LLC. As used in these conditions,
                                Kangaroo includes Kangaroo Express Delivery Company LLC., all operating divisions and
                                subsidiaries of Kangaroo Express Delivery Company LLC., and their respective agents,
                                servants,
                                officers and employees.
                                <ol>
                                    <li>
                                        <b>SCOPE OF CONDITIONS</b>
                                        <p>These conditions shall govern and apply to all services provided by Kangaroo.
                                            BY SIGNING
                                            THIS
                                            WAYBILL, THE COSTUMER AKNOWLEDGES THAT HE/SHE HAS READ THESE CONDITIONS AND
                                            AGREES TO BE
                                            BOUND
                                            BY EACH OF THEM. Kangaroo shall not be bound by any agreement which varies
                                            from these
                                            conditions, unless such agreement is in writing and signed by an authorized
                                            officer or
                                            Kangaroo.
                                            In the absence of such written agreements, these conditions shall constitute
                                            the entire
                                            agreement between Kangaroo and each of its customers. No employee of
                                            Kangaroo shall have
                                            the
                                            authority to alter or waive these terms and conditions, except as stated
                                            herein.</p>
                                    </li>
                                    <li>
                                        <b>KANGAROO’S OBLIGATION</b>
                                        <p>Kangaroo agrees, subject to receiving payment of applicable rates and charges
                                            in effect
                                            on the
                                            date of acceptance by Kangaroo of a customer’s shipment, to arrange for the
                                            transportation of
                                            the shipment between the locations agreed upon by Kangaroo and the customer.
                                            Kangaroo
                                            reserves
                                            the right to transport the customer’s shipment by any route and procedure
                                            and by
                                            successive
                                            carriers and according to its own handling, storage and transportation
                                            methods.</p>
                                    </li>
                                    <li>
                                        <b>SERVICE RESTRECTIONS</b>
                                        <p>a) Kangaroo reserves the right to refuse any documents or parcels from any
                                            person, firm
                                            or
                                            company at its own discretion.
                                            b) Kangaroo reserves the right to abandon carriage of any shipment at any
                                            time after
                                            acceptance
                                            when such shipment could possibly cause damage or delay to other shipments,
                                            equipment or
                                            personnel, or when any such carriage is prohibited by law or is in violation
                                            of any of
                                            the
                                            conditions contained herein.
                                            c) Kangaroo reserves the right to open and inspect any shipment consigned by
                                            a customer
                                            to
                                            ensure that it is capable of carriage to the destination within the standard
                                            customs
                                            procedures
                                            and handling methods of Kangaroo. In exercising this right, Kangaroo does
                                            not warrant
                                            that any
                                            particular item to be carried is capable of carriage, without infringing the
                                            law.</p>
                                    </li>
                                    <li>
                                        <b>LIMITATION OF LIABILITY</b>
                                        <p>Subject of Sections 5 and 6 hereto:
                                            a) Kangaroo will be responsible for the customer’s shipment only while it is
                                            within
                                            Kangaroo’s
                                            custody and control. Kangaroo shall not be liable for loss or damage of a
                                            shipment while
                                            the
                                            shipment is out of Kangaroo’s custody or control. KANGAROO’S LIABILITY IS IN
                                            ANY EVENT
                                            LIMITED
                                            TO TWENTY FIVE US DOLLARS (US$ 25/-) or its equivalent per shipment unless a
                                            higher
                                            value is
                                            declared on the waybill at the time of tender and an additional charge is
                                            paid for, as
                                            assessed
                                            and determined by Kangaroo, for each twenty five dollars (US$ 25/-) or
                                            fraction thereof,
                                            by
                                            which the insured value designated by the customer on the waybill exceeds
                                            Twenty Five
                                            Dollars
                                            (US$25/-) per shipment.
                                            b) Notwithstanding the foregoing, should the customer, at the time of
                                            tender, declare a
                                            higher
                                            value than Twenty Five Dollars (US$ 25/-) on the waybill, Kangaroo’s
                                            liability shall in
                                            any
                                            event be limited to the lower of the insured value of the amount of any loss
                                            or damage
                                            actually
                                            sustained by the customer.
                                            c) The actual value of shipment shall be ascertained by reference to its
                                            replacements,
                                            reconstitution value at the time and place of shipment, whichever is less,
                                            without
                                            reference to
                                            its commercial utility to the costumer or to other items of consequential
                                            loss.

                                            d) NOTWITHSTANDING ANY OF THE FOREGOING, THE MAXIMUM INSURED VALUE OF ANY
                                            SHIPMENT
                                            ACCEPTED BY
                                            KANGAROO IS TEN THOUSAND DOLLARS (US$ 10,000/=) AND NO EVENT SHALL THE
                                            LIABILITY OF
                                            KANGAROO
                                            EXCEED THAT AMOUNT.</p>
                                    </li>
                                    <li>
                                        <b>CONSEQUENTIAL DAMAGES EXCLUDED</b>
                                        <p>KANGRAOO SHALL NOT BE LIABLE, IN ANY EVENT FOR ANY CONSEQUENTIAL OF SPECIAL
                                            OR
                                            INCIDENTAL.
                                            DAMAGE OR OTHER INDIRECT LOSS HOWEVER ARISING, WHETHER OR NOT KANGAROO HAD
                                            KNOWLEDGE
                                            THAT SUCH
                                            DAMAGE MIGHT BE INCURRED INCLUDING, BUT NOT LIMITED TO LOSS OF INCOME,
                                            PROFITS,
                                            INTEREST,
                                            UTILITY OR LOSS OF MARKET.</p>
                                    </li>
                                    <li>
                                        <b>LIABILITIES NOT ASSUMED</b>
                                        <p>a) Kangaroo shall not be liable for any loss, damage, delay, misdelivery,
                                            non-delivery
                                            not
                                            caused by its own negligence, or for any loss, damage, delay, misdelivery or
                                            non-delivery caused
                                            by:
                                            • The act, default or omission of the shipper or consignee or any other
                                            party who claims
                                            an
                                            interest in the shipment.
                                            • The nature of the shipment or any defect, characteristic, or inherent vice
                                            thereof.
                                            • Violation by the shipper or consignee of any term or condition stated
                                            herein
                                            including, but
                                            not limited to, improper or insufficient packing, securing marking or
                                            addressing
                                            misdescribing
                                            the contents of any shipment or failure to observe any of these rules
                                            relating to the
                                            shipment
                                            not being acceptable for transportation whether such rules are now or
                                            hereafter
                                            promulgated by
                                            Kangaroo.
                                            • Acts of God, perils of the air, public enemies, public authorities acting
                                            with actual
                                            or
                                            apparent authority or law, acts or omission of postal, customs or other
                                            government
                                            officials,
                                            riots, strikes or other local disputes, hazard incidents to a state of war,
                                            weather
                                            conditions,
                                            temperature or atmospheric changes or conditions, mechanical or other delay
                                            of any
                                            vehicle or
                                            any other means used in providing transportation services or any other cause
                                            reasonably
                                            beyond
                                            the control of Kangaroo.
                                            • Acts of omissions of any postal service, forwarder or any other entity to
                                            whom a
                                            shipment is
                                            tendered by Kangaroo for transportation, regardless of whether the requested
                                            or had
                                            knowledge of
                                            such third party delivery requirement.
                                            • Electrical or magnetic injury, erasure, or other such damage to electronic
                                            or
                                            photographic
                                            images or recordings in any form, or damage due to insects or vermin.
                                            b) While Kangaroo will endeavor to exercise its best efforts to provide
                                            expeditious
                                            delivery in
                                            accordance with regular delivery schedules, Kangaroo will not under any
                                            circumstances be
                                            liable
                                            for delay in pickup, transportation or delivery of any shipment regardless
                                            of the causes
                                            of such
                                            delay.</p>
                                    </li>
                                    <li>
                                        <b>MATERIALS NOT ACCEPTABLE FOR TRANSPORT</b>
                                        <p>a) Kangaroo will notify customer from time to time as to certain classes of
                                            materials
                                            which are
                                            not accepted by Kangaroo for carriage. It is the customer’s responsibility
                                            to accurately
                                            describe the shipment on this waybill and to ensure that no material is
                                            delivered to
                                            Kangaroo
                                            which has been declared to be unacceptable by Kangaroo.
                                            b) Kangaroo will not carry property, the carriage of which is prohibited by
                                            any law,
                                            regulation
                                            or instructions as well as any of the following materials or items:
                                            Firearms Lewd, obscene or pornographic materials Money orders
                                            bullion Currency Traveler’s checks
                                            Works of art Stamps Industrial cartons and diamonds
                                            Negotiable instruments in bearer form Deeds Antiques
                                            Jewelry Hazardous or combustible materials Plants
                                            Precious metals Cashier’s checks Animals
                                            Precious stones

                                            c) In the event that any customer should consign to Kangaroo any such item,
                                            as described
                                            above,
                                            or any item which the customer has undervalued for customs purposes or
                                            misdescribed,
                                            whether
                                            intentionally or otherwise the customer shall indemnify and hold Kangaroo
                                            harmless from
                                            all
                                            claims, damages, fines and expenses arising in connection therewith, and
                                            Kangaroo shall
                                            have the
                                            right to abandon such property and/or release possession of said property to
                                            any agent
                                            or
                                            employed of any national or local government claiming jurisdiction over such
                                            materials.
                                            Immediately upon Kangaroo’s obtaining knowledge that such materials
                                            infringing these
                                            conditions
                                            have been turned over to Kangaroo for transport. Kangaroo shall be free to
                                            exercise any
                                            of its
                                            rights reserved to it under this section without incurring liability
                                            whatsoever to the
                                            customer.</p>
                                    </li>
                                    <li>
                                        <b>PACKAGING AND ADDRESSING</b>
                                        <p>The packaging of the customer’s documents or goods for transportation is the
                                            customer’s
                                            sole
                                            responsibility, including the placing of the goods or documents in any
                                            container which
                                            may be
                                            supplied by the customer to Kangaroo. Kangaroo accepts no responsibility for
                                            loss or
                                            damage to
                                            documents or goods caused by inadequate or inappropriate packaging. It is
                                            the sole
                                            responsibility of the customer to address adequately each consignment or
                                            documents or
                                            goods to
                                            enable effective delivery to be made. Kangaroo shall not be liable for delay
                                            in
                                            forwarding or
                                            delivery resulting from the customer’s failure to comply with its
                                            obligations in this
                                            respect.</p>
                                    </li>
                                    <li>
                                        <b>NEGLIGENCE</b>
                                        <p>The customer is liable for all loses, damages, and expenses arising as a
                                            result of its
                                            failure
                                            to comply with its obligations under this agreement as a result of its
                                            negligence.</p>
                                    </li>
                                    <li>
                                        <b>CHARGES</b>
                                        <p>Any rates quoted by Kangaroo for carriage are exclusive of any value added or
                                            sales
                                            taxes,
                                            duties, levies, imposts or outlays incurred in respect of carriage of the
                                            customer’s
                                            goods.
                                            Should the customer indicate by endorsement in the space provided on the
                                            Waybill of
                                            lading that
                                            the receiver shall be liable for any amount, the customer shall be liable
                                            for such
                                            amount in the
                                            event of default in payment by the receiver. Kangaroo will not be liable for
                                            any
                                            penalties
                                            imposed or loss or damage incurred due to the customer’s documents or goods
                                            being
                                            impounded by
                                            authorities and the customer hereby indemnifies Kangaroo against such
                                            penalty or loss.</p>
                                    </li>
                                    <li>
                                        <b>PROPERTY</b>
                                        <p>Kangaroo will only carry documents or goods which are the property of the
                                            customer
                                            warrants that
                                            it is authorized to accept and is accepting these conditions not only on
                                            behalf of
                                            itself but as
                                            agent and on behalf of all other persons who are or may hereafter be
                                            interested in the
                                            documents
                                            or goods. The customer hereby undertakes to indemnify Kangaroo against any
                                            damages,
                                            costs and
                                            expenses resulting from any breach of this warranty.
                                        </p>
                                    </li>
                                    <li>
                                        <b>CLAIMS</b>
                                        <p>ANY CLAIMS AGAINST KANGAROO MUST BE SUBMITTED IN WRITING TO THE OFFICE OF
                                            KANGAROO
                                            NEAREST THE
                                            LOCATION WHERE THE SHIPMENT WAS ACCEPTED, WITHIN SIXTY (60) DAYS OF THE DATE
                                            OF
                                            ACCEPTANCE BY
                                            KANGAROO.
                                            Notwithstanding any of the foregoing, no claim for loss or damage will be
                                            entertained
                                            until all
                                            transportation charges have been paid.</p>
                                    </li>
                                    <li>
                                        <b>NON-DELIVERY OF SHIPMENT</b>
                                        <p>Notwithstanding the shipper’s instruction to the contrary, the shipper, will
                                            be liable
                                            for all
                                            costs and expenses related to the shipment of the package, and for costs
                                            incurred in
                                            either
                                            returning the shipment or warehousing the shipment pending disposition.</p>
                                    </li>
                                    <li>
                                        <b>INSURANCE</b>
                                        <p>a) Kangaroo maintains cargo liability insurance to the full extent of the
                                            liability
                                            offered to
                                            the shipper.
                                            b) At the request of the shipper and upon payment therefor at the then
                                            prevailing rates,
                                            Kangaroo will arrange insurance coverage on behalf of the shipper in an
                                            amount not
                                            exceeding Ten
                                            Thousand Dollars (US$ 10,000/=).
                                            c) The insurance cover shall be governed by all the terms and conditions
                                            contained in
                                            the policy
                                            of insurance issued by the insurance career. A certificate evidencing such
                                            insurance
                                            will be
                                            made available to the shipper.
                                            d) CONSEQUENTIAL DAMAGES AND LOSS OR DAMAGE RESULTING FROM DELAYS IN
                                            TRANSPORTATION ARE
                                            NOT
                                            COVERED BY ANY SUCH POLICY OF INSURANCE.</p>
                                    </li>
                                </ol>

                                THIS IS A NON-NEGOTIABLE WAYBILL. ALL SERVICES PROVIDED ARE SUBJECT TO THE TERMS AND
                                CONDITIONS
                                SET FORTH ON THE REVERSE OF SHIPPER’S COPY. BY SIGNING THIS WAYBILL, THE SHIPPER
                                ACKNOWLEDGES
                                THAT HE/SHE HAS READ THESE CONDITIONS AND AGREES TO BE BOUND BY EACH OF THEM. KANGAROO’S
                                LIMITED
                                TO US$ 25/-. IN TENDERING THIS SHIPMENT, SHIPPER AGREES THAT KANGAROO SHALL NOT BE
                                LIABLE FOR
                                SPECIAL INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING FROM THE CARRIAGE HEREOF, KANGAROO
                                DISCLAIMS
                                ALL WARANTIES, EXPRESS OR IMPLIED, WITH RESPECT TO THIS SHIPMENT.
                            </div>
                        </div>
                    </td>
                </tr>

            </table>

        </section>
    </div>
@endsection